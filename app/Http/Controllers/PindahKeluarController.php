<?php

namespace App\Http\Controllers;

use App\Models\BiodataWarga;
use App\Models\PindahKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PindahKeluarController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $from = $request->get('from');
        $to = $request->get('to');

        $query = PindahKeluar::with('warga')->latest();

        $user = auth()->user();
        if ($user && method_exists($user, 'isKepalaLingkungan') && $user->isKepalaLingkungan()) {
            $lingkungan = $user->lingkungan;
            // If biodata_warga has a denormalized 'lingkungan' column, filter directly on it for performance.
            if (Schema::hasColumn('biodata_warga', 'lingkungan')) {
                $query->whereHas('warga', function ($q) use ($lingkungan) {
                    $q->where('lingkungan', $lingkungan);
                });
            } else {
                // fallback: filter via the family relationship
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

        // filter by tanggal_pindah range when provided
        if (!empty($from)) {
            // expect YYYY-MM-DD or similar; use whereDate for safety
            $query->whereDate('tanggal_pindah', '>=', $from);
        }

        if (!empty($to)) {
            $query->whereDate('tanggal_pindah', '<=', $to);
        }

        $items = $query->paginate(20);
        return view('pindah_keluar.index', compact('items', 'q', 'from', 'to'));
    }

    public function create(Request $request)
    {
        $q = $request->get('q');
        $wargas = collect();
        $selectedWarga = null;

        // if a warga_id is passed, load that warga for the form page
        if ($request->filled('warga_id')) {
            $selectedWarga = BiodataWarga::with('family')->find($request->get('warga_id'));
        }

        if ($q) {
            $wargaQuery = BiodataWarga::query()
                                ->where(function ($s) use ($q) {
                                        $s->where('nik', 'like', "%{$q}%")
                                            ->orWhere('nama_lgkp', 'like', "%{$q}%");
                                });

            // only show active residents for selection
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

        return view('pindah_keluar.create', compact('wargas', 'q', 'selectedWarga'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'warga_id' => 'required|exists:biodata_warga,id',
            'tanggal_pindah' => 'required|date',
            'tujuan' => 'nullable|string|max:500',
            'jenis_pindah' => [
                'nullable',
                Rule::in(config('pindah_keluar.jenis')),
            ],
            'keterangan' => 'nullable|string',
        ]);

        $warga = BiodataWarga::find($data['warga_id']);
        $data['no_kk'] = $warga->no_kk ?? null;
        $data['family_id'] = $warga->family_id ?? null;
        // take lingkungan from biodata_warga if available
        $data['lingkungan'] = $warga->lingkungan ?? ($warga->family?->lingkungan ?? null);
        // populate alamat on pindah_keluar from biodata_warga.alamat (fallback to family alamat)
        $data['alamat'] = $warga->alamat ?? ($warga->family?->alamat ?? null);
        $data['created_by'] = auth()->id();

        $p = PindahKeluar::create($data);

        return redirect()->route('pindah_keluar.index')->with('success', 'Pencatatan pindah keluar tersimpan.');
    }

    public function edit(PindahKeluar $pindah_keluar)
    {
        // load relation for display
        $pindah_keluar->load('warga', 'creator');
        return view('pindah_keluar.edit', ['item' => $pindah_keluar]);
    }

    public function update(Request $request, PindahKeluar $pindah_keluar)
    {
        $data = $request->validate([
            'tanggal_pindah' => 'required|date',
            'tujuan' => 'nullable|string|max:500',
            'jenis_pindah' => ['nullable', Rule::in(config('pindah_keluar.jenis'))],
            'keterangan' => 'nullable|string',
        ]);

        $pindah_keluar->update($data);

        return redirect()->route('pindah_keluar.index')->with('success', 'Pencatatan pindah keluar diperbarui.');
    }

    public function show(PindahKeluar $pindah_keluar)
    {
        $pindah_keluar->load('warga','family','creator');
        return view('pindah_keluar.show', ['item' => $pindah_keluar]);
    }

    public function destroy(PindahKeluar $pindah_keluar)
    {
        $warga = $pindah_keluar->warga;

        DB::transaction(function () use ($pindah_keluar, $warga) {
            if ($warga) {
                // restore resident flag_status to 'Aktif' when a pindah record is removed
                try {
                    $warga->update(['flag_status' => 'Aktif']);
                } catch (\Throwable $e) {
                    // ignore update failure here; deletion should still proceed
                }
            }

            $pindah_keluar->delete();
        });

        return redirect()->route('pindah_keluar.index')->with('success', 'Pencatatan pindah keluar dihapus.');
    }
}
