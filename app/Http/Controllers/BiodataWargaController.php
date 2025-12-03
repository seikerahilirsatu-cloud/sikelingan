<?php

namespace App\Http\Controllers;

use App\Models\BiodataWarga;
use App\Models\DataKeluarga;
use App\Http\Requests\StoreBiodataWargaRequest;
use App\Http\Requests\UpdateBiodataWargaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class BiodataWargaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = BiodataWarga::query();
        if ($q !== null && $q !== '') {
            $mq = strtolower(trim($q));
            $monthMap = [
                'januari' => 1, 'februari' => 2, 'maret' => 3, 'april' => 4,
                'mei' => 5, 'juni' => 6, 'juli' => 7, 'agustus' => 8,
                'september' => 9, 'oktober' => 10, 'november' => 11, 'desember' => 12,
                'january' => 1, 'february' => 2, 'march' => 3, 'april' => 4,
                'may' => 5, 'june' => 6, 'july' => 7, 'august' => 8,
                'september' => 9, 'october' => 10, 'november' => 11, 'december' => 12,
            ];
            $query->where(function($s) use ($q, $mq, $monthMap) {
                $s->where('nik','like',"%{$q}%")
                  ->orWhere('nama_lgkp','like',"%{$q}%")
                  ->orWhere('no_kk','like',"%{$q}%");
                if (isset($monthMap[$mq])) {
                    $s->orWhereMonth('tgl_lhr', $monthMap[$mq]);
                }
            });
        }

        $user = Auth::user();
        if ($user && $user->role === 'kepala_lingkungan') {
            // Prefer filtering directly on biodata_warga.lingkungan if the column exists (faster).
            if (Schema::hasColumn('biodata_warga', 'lingkungan')) {
                $query->where('lingkungan', $user->lingkungan);
            } else {
                // restrict residents to those whose family has same lingkungan
                $query->whereHas('family', function($q) use ($user) {
                    $q->where('lingkungan', $user->lingkungan);
                });
            }
        }

        $residents = $query->orderBy('id','desc')->paginate(12);

        return view('biodata_warga.index', compact('residents','q'));
    }

    public function create()
    {
        $families = DataKeluarga::orderBy('no_kk')->get();
        $user = Auth::user();
        $defaultFamilyId = null;
        if ($user && $user->role === 'kepala_lingkungan') {
            // optionally limit families to that lingkungan in the select
            $families = $families->filter(fn($f) => $f->lingkungan == $user->lingkungan);
        }
        return view('biodata_warga.create', compact('families'));
    }

    public function store(StoreBiodataWargaRequest $request)
    {
        $data = $request->validated();
        // if no family_id but no_kk provided, try to find family
        if (empty($data['family_id']) && !empty($data['no_kk'])) {
            $family = DataKeluarga::where('no_kk', $data['no_kk'])->first();
            if ($family) $data['family_id'] = $family->id;
        }

        BiodataWarga::create($data);
        return redirect()->route('biodata_warga.index')->with('success','Data warga berhasil disimpan.');
    }

    public function show(BiodataWarga $biodataWarga)
    {
        return view('biodata_warga.show', ['resident' => $biodataWarga]);
    }

    public function edit(BiodataWarga $biodataWarga)
    {
        $families = DataKeluarga::orderBy('no_kk')->get();
        return view('biodata_warga.edit', ['resident' => $biodataWarga, 'families' => $families]);
    }

    public function update(UpdateBiodataWargaRequest $request, BiodataWarga $biodataWarga)
    {
        $biodataWarga->update($request->validated());
        return redirect()->route('biodata_warga.index')->with('success','Data warga diperbarui.');
    }

    public function destroy(BiodataWarga $biodataWarga)
    {
        $biodataWarga->delete();
        return redirect()->route('biodata_warga.index')->with('success','Data warga dihapus.');
    }
}
