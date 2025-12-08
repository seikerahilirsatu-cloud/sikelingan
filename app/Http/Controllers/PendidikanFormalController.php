<?php

namespace App\Http\Controllers;

use App\Models\PendidikanFormal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendidikanFormalController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $lingkungan = $request->input('lingkungan');
        $query = PendidikanFormal::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama_sekolah','like',"%$q%")
                  ->orWhere('jenjang','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));
        $user = Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) { $lingkungan = $user->lingkungan; }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') { $query->where('lingkungan', $user->lingkungan); }
        $items = $query->orderBy('id','desc')->paginate(12);
        return view('pendidikan_formal.index', compact('items','q','lingkungan'));
    }

    public function create()
    {
        $jenjangOpts = config('pendidikan.jenjang', []);
        $lingkunganOpts = config('app_local.lingkungan_opts', []);
        return view('pendidikan_formal.create', compact('jenjangOpts','lingkunganOpts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => ['required','string', function($attr,$value,$fail){ $opts=config('pendidikan.jenjang',[]); if(!in_array($value,$opts)) $fail('Invalid jenjang'); }],
            'jenis_sekolah' => 'nullable|in:Negeri,Swasta',
            'tahun_berdiri' => 'nullable|integer',
            'sk_pendirian' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'lingkungan' => ['nullable','string', function($attr,$value,$fail){ $opts=config('app_local.lingkungan_opts',[]); if($value && !in_array($value,$opts)) $fail('Invalid lingkungan'); }],
            'stts_sekolah' => 'nullable|in:Aktif,Tidak Aktif',
            'jlh_ruang_kelas' => 'nullable|integer',
            'jlh_perpustakaan' => 'nullable|integer',
            'jlh_lab' => 'nullable|integer',
            'jlh_wc' => 'nullable|integer',
            'kantin' => 'nullable|in:Ada,Tidak Ada',
            'nama_kep_sekolah' => 'nullable|string|max:255',
            'jlh_guru_pegawai' => 'nullable|integer',
            'jlh_guru_honor' => 'nullable|integer',
            'jumlah_siswa' => 'nullable|integer',
            'photo' => 'nullable|image',
        ]);
        if ($request->hasFile('photo')) {
            $disk = 'public';
            $path = $request->file('photo')->storePublicly('pendidikan_formal', $disk);
            try { Storage::disk($disk)->setVisibility($path, 'public'); } catch(\Throwable $e) {}
            $data['photo_path'] = $path;
        }
        unset($data['photo']);
        $item = PendidikanFormal::create($data);
        return redirect()->route('pendidikan_formal.index')->with('success','Data pendidikan formal berhasil disimpan.');
    }

    public function show(PendidikanFormal $pendidikan_formal)
    {
        return view('pendidikan_formal.show', ['item' => $pendidikan_formal]);
    }

    public function edit(PendidikanFormal $pendidikan_formal)
    {
        $jenjangOpts = config('pendidikan.jenjang', []);
        $lingkunganOpts = config('app_local.lingkungan_opts', []);
        return view('pendidikan_formal.edit', ['item' => $pendidikan_formal, 'jenjangOpts' => $jenjangOpts, 'lingkunganOpts' => $lingkunganOpts]);
    }

    public function update(Request $request, PendidikanFormal $pendidikan_formal)
    {
        $data = $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'jenjang' => ['required','string', function($attr,$value,$fail){ $opts=config('pendidikan.jenjang',[]); if(!in_array($value,$opts)) $fail('Invalid jenjang'); }],
            'jenis_sekolah' => 'nullable|in:Negeri,Swasta',
            'tahun_berdiri' => 'nullable|integer',
            'sk_pendirian' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'lingkungan' => ['nullable','string', function($attr,$value,$fail){ $opts=config('app_local.lingkungan_opts',[]); if($value && !in_array($value,$opts)) $fail('Invalid lingkungan'); }],
            'stts_sekolah' => 'nullable|in:Aktif,Tidak Aktif',
            'jlh_ruang_kelas' => 'nullable|integer',
            'jlh_perpustakaan' => 'nullable|integer',
            'jlh_lab' => 'nullable|integer',
            'jlh_wc' => 'nullable|integer',
            'kantin' => 'nullable|in:Ada,Tidak Ada',
            'nama_kep_sekolah' => 'nullable|string|max:255',
            'jlh_guru_pegawai' => 'nullable|integer',
            'jlh_guru_honor' => 'nullable|integer',
            'jumlah_siswa' => 'nullable|integer',
            'photo' => 'nullable|image',
        ]);
        if ($request->hasFile('photo')) {
            $disk = 'public';
            $path = $request->file('photo')->storePublicly('pendidikan_formal', $disk);
            if (!empty($pendidikan_formal->photo_path)) { Storage::disk($disk)->delete($pendidikan_formal->photo_path); }
            try { Storage::disk($disk)->setVisibility($path, 'public'); } catch(\Throwable $e) {}
            $data['photo_path'] = $path;
        }
        unset($data['photo']);
        $pendidikan_formal->update($data);
        return redirect()->route('pendidikan_formal.index')->with('success','Data pendidikan formal diperbarui.');
    }

    public function destroy(PendidikanFormal $pendidikan_formal)
    {
        $pendidikan_formal->delete();
        return redirect()->route('pendidikan_formal.index')->with('success','Data pendidikan formal dihapus.');
    }
}
