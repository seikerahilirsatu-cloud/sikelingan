<?php

namespace App\Http\Controllers;

use App\Models\BiodataWarga;
use App\Models\WargaMeninggal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class WargaMeninggalController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $from = $request->get('from');
        $to = $request->get('to');

        $query = WargaMeninggal::with('warga')->latest();

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
            $query->whereDate('tanggal_meninggal', '>=', $from);
        }

        if (!empty($to)) {
            $query->whereDate('tanggal_meninggal', '<=', $to);
        }

        $items = $query->paginate(20);
        return view('warga_meninggal.index', compact('items', 'q', 'from', 'to'));
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

        return view('warga_meninggal.create', compact('wargas', 'q', 'selectedWarga'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'warga_id' => 'required|exists:biodata_warga,id',
            'tanggal_meninggal' => 'required|date',
            'waktu_meninggal' => 'nullable',
            'tempat_meninggal' => 'nullable|string|max:255',
            'sebab_meninggal' => 'nullable|string',
            'tanggal_dikebumikan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $warga = BiodataWarga::find($data['warga_id']);
        $data['no_kk'] = $warga->no_kk ?? null;
        $data['family_id'] = $warga->family_id ?? null;
        $data['lingkungan'] = $warga->lingkungan ?? ($warga->family?->lingkungan ?? null);
        $data['alamat'] = $warga->alamat ?? ($warga->family?->alamat ?? null);
        $data['created_by'] = auth()->id();

        DB::transaction(function () use ($data, $warga) {
            // create record
            $rec = WargaMeninggal::create($data);

            // update warga flag_status to 'Meninggal'
            if ($warga) {
                try {
                    $warga->update(['flag_status' => 'Meninggal']);
                } catch (\Throwable $e) {
                    // ignore
                }
            }
        });

        return redirect()->route('warga_meninggal.index')->with('success', 'Data warga meninggal tersimpan.');
    }

    public function edit(WargaMeninggal $warga_meninggal)
    {
        $warga_meninggal->load('warga', 'creator');
        return view('warga_meninggal.edit', ['item' => $warga_meninggal]);
    }

    public function update(Request $request, WargaMeninggal $warga_meninggal)
    {
        $data = $request->validate([
            'tanggal_meninggal' => 'required|date',
            'waktu_meninggal' => 'nullable',
            'tempat_meninggal' => 'nullable|string|max:255',
            'sebab_meninggal' => 'nullable|string',
            'tanggal_dikebumikan' => 'nullable|date',
            'keterangan' => 'nullable|string',
        ]);

        $warga_meninggal->update($data);

        return redirect()->route('warga_meninggal.index')->with('success', 'Data warga meninggal diperbarui.');
    }

    public function destroy(WargaMeninggal $warga_meninggal)
    {
        $warga = $warga_meninggal->warga;

        DB::transaction(function () use ($warga_meninggal, $warga) {
            // optionally restore flag_status to 'Aktif' if desired; we will try
            if ($warga) {
                try {
                    $warga->update(['flag_status' => 'Aktif']);
                } catch (\Throwable $e) {
                    // ignore
                }
            }

            $warga_meninggal->delete();
        });

        return redirect()->route('warga_meninggal.index')->with('success', 'Data warga meninggal dihapus.');
    }
}
