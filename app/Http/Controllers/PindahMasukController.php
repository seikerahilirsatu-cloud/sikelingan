<?php

namespace App\Http\Controllers;

use App\Models\BiodataWarga;
use App\Models\PindahMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PindahMasukController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $from = $request->get('from');
        $to = $request->get('to');

        $query = PindahMasuk::with('warga')->latest();

        $user = auth()->user();
        if ($user && method_exists($user, 'isKepalaLingkungan') && $user->isKepalaLingkungan()) {
            $lingkungan = $user->lingkungan;
            if (Schema::hasColumn('biodata_warga', 'lingkungan')) {
                $query->whereHas('warga', function ($q) use ($lingkungan) {
                    $q->where('lingkungan', $lingkungan);
                });
            } else {
                $query->whereHas('warga', function ($q) use ($lingkungan) {
                    $q->whereHas('family', function ($fq) use ($lingkungan) {
                        $fq->where('lingkungan', $lingkungan);
                    });
                });
            }
        }

        if ($q) {
            $query->whereHas('warga', function ($w) use ($q) {
                $w->where('nik', 'like', "%{$q}%")
                  ->orWhere('nama_lgkp', 'like', "%{$q}%")
                  ->orWhere('no_kk', 'like', "%{$q}%");
            });
        }

        if (!empty($from)) {
            $query->whereDate('tanggal_masuk', '>=', $from);
        }

        if (!empty($to)) {
            $query->whereDate('tanggal_masuk', '<=', $to);
        }

        $items = $query->paginate(20);
        return view('pindah_masuk.index', compact('items', 'q', 'from', 'to'));
    }

    public function create(Request $request)
    {
        $q = $request->get('q');
        $wargas = collect();
        $selectedWarga = null;

        if ($request->filled('warga_id')) {
            $selectedWarga = BiodataWarga::with('family')->find($request->get('warga_id'));
        }

        if ($q) {
            $wargaQuery = BiodataWarga::query()
                                ->where(function ($s) use ($q) {
                                        $s->where('nik', 'like', "%{$q}%")
                                            ->orWhere('nama_lgkp', 'like', "%{$q}%");
                                });

            $wargaQuery->where('flag_status', 'Aktif');

            $user = auth()->user();
            if ($user && method_exists($user, 'isKepalaLingkungan') && $user->isKepalaLingkungan()) {
                $lingkungan = $user->lingkungan;
                $wargaQuery->whereHas('family', function ($fq) use ($lingkungan) {
                    $fq->where('lingkungan', $lingkungan);
                });
            }

            $wargas = $wargaQuery->limit(50)->get();
        }

        return view('pindah_masuk.create', compact('wargas', 'q', 'selectedWarga'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'warga_id' => 'required|exists:biodata_warga,id',
            'tanggal_masuk' => 'required|date',
            'asal' => 'nullable|string|max:500',
            'jenis_masuk' => [
                'nullable',
                Rule::in(config('pindah_masuk.jenis')),
            ],
            'keterangan' => 'nullable|string',
        ]);

        $warga = BiodataWarga::find($data['warga_id']);
        $data['no_kk'] = $warga->no_kk ?? null;
        $data['family_id'] = $warga->family_id ?? null;
        $data['lingkungan'] = $warga->lingkungan ?? ($warga->family?->lingkungan ?? null);
        $data['alamat'] = $warga->alamat ?? ($warga->family?->alamat ?? null);
        // ensure compatibility with model fillable keys
        if (isset($data['tanggal_masuk'])) {
            $data['tanggal_masuk'] = $data['tanggal_masuk'];
        }
        if (isset($data['jenis_masuk'])) {
            $data['jenis_masuk'] = $data['jenis_masuk'];
        }
        $data['created_by'] = auth()->id();

        $p = PindahMasuk::create($data);

        return redirect()->route('pindah_masuk.index')->with('success', 'Pencatatan pindah masuk tersimpan.');
    }

    public function edit(PindahMasuk $pindah_masuk)
    {
        $pindah_masuk->load('warga', 'creator');
        return view('pindah_masuk.edit', ['item' => $pindah_masuk]);
    }

    public function update(Request $request, PindahMasuk $pindah_masuk)
    {
        $data = $request->validate([
            'tanggal_masuk' => 'required|date',
            'asal' => 'nullable|string|max:500',
            'jenis_masuk' => ['nullable', Rule::in(config('pindah_masuk.jenis'))],
            'keterangan' => 'nullable|string',
        ]);

        $pindah_masuk->update($data);

        return redirect()->route('pindah_masuk.index')->with('success', 'Pencatatan pindah masuk diperbarui.');
    }

    public function show(PindahMasuk $pindah_masuk)
    {
        $pindah_masuk->load('warga','family','creator');
        return view('pindah_masuk.show', ['item' => $pindah_masuk]);
    }

    public function destroy(PindahMasuk $pindah_masuk)
    {
        $warga = $pindah_masuk->warga;

        DB::transaction(function () use ($pindah_masuk, $warga) {
            if ($warga) {
                try {
                    $warga->update(['flag_status' => 'Aktif']);
                } catch (\Throwable $e) {
                    // ignore
                }
            }

            $pindah_masuk->delete();
        });

        return redirect()->route('pindah_masuk.index')->with('success', 'Pencatatan pindah masuk dihapus.');
    }
}
