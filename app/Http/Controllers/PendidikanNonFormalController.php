<?php

namespace App\Http\Controllers;

use App\Models\PendidikanNonFormal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendidikanNonFormalController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $lingkungan = $request->input('lingkungan');
        $query = PendidikanNonFormal::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama_lembaga','like',"%$q%")
                  ->orWhere('bidang_pelatihan','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));
        $user = Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) { $lingkungan = $user->lingkungan; }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') { $query->where('lingkungan', $user->lingkungan); }
        $items = $query->orderBy('id','desc')->paginate(12);
        return view('pendidikan_non_formal.index', compact('items','q','lingkungan'));
    }

    public function create()
    {
        $bidangOpts = config('pendidikan.bidang_pelatihan', []);
        $lingkunganOpts = config('app_local.lingkungan_opts', []);
        return view('pendidikan_non_formal.create', compact('bidangOpts','lingkunganOpts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'bidang_pelatihan' => ['required','string', function($attr,$value,$fail){ $opts=config('pendidikan.bidang_pelatihan',[]); if(!in_array($value,$opts)) $fail('Invalid bidang_pelatihan'); }],
            'tahun_berdiri' => 'nullable|integer',
            'sk_pendirian' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_kontak' => 'nullable|string|max:50',
            'lingkungan' => ['nullable','string', function($attr,$value,$fail){ $opts=config('app_local.lingkungan_opts',[]); if($value && !in_array($value,$opts)) $fail('Invalid lingkungan'); }],
            'nama_pemilik' => 'nullable|string|max:255',
            'stts_lembaga' => 'nullable|in:Aktif,Tidak Aktif',
            'jumlah_siswa' => 'nullable|integer',
            'photo' => 'nullable|image',
        ]);
        if ($request->hasFile('photo')) {
            $disk = config('filesystems.default');
            $path = $request->file('photo')->storePublicly('pendidikan_non_formal', $disk);
            try { Storage::disk($disk)->setVisibility($path, 'public'); } catch(\Throwable $e) {}
            $data['photo_path'] = $path;
        }
        unset($data['photo']);
        PendidikanNonFormal::create($data);
        return redirect()->route('pendidikan_non_formal.index')->with('success','Data pendidikan non-formal berhasil disimpan.');
    }

    public function show(PendidikanNonFormal $pendidikan_non_formal)
    {
        return view('pendidikan_non_formal.show', ['item' => $pendidikan_non_formal]);
    }

    public function edit(PendidikanNonFormal $pendidikan_non_formal)
    {
        $bidangOpts = config('pendidikan.bidang_pelatihan', []);
        $lingkunganOpts = config('app_local.lingkungan_opts', []);
        return view('pendidikan_non_formal.edit', ['item' => $pendidikan_non_formal, 'bidangOpts' => $bidangOpts, 'lingkunganOpts' => $lingkunganOpts]);
    }

    public function update(Request $request, PendidikanNonFormal $pendidikan_non_formal)
    {
        $data = $request->validate([
            'nama_lembaga' => 'required|string|max:255',
            'bidang_pelatihan' => ['required','string', function($attr,$value,$fail){ $opts=config('pendidikan.bidang_pelatihan',[]); if(!in_array($value,$opts)) $fail('Invalid bidang_pelatihan'); }],
            'tahun_berdiri' => 'nullable|integer',
            'sk_pendirian' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
            'no_kontak' => 'nullable|string|max:50',
            'lingkungan' => ['nullable','string', function($attr,$value,$fail){ $opts=config('app_local.lingkungan_opts',[]); if($value && !in_array($value,$opts)) $fail('Invalid lingkungan'); }],
            'nama_pemilik' => 'nullable|string|max:255',
            'stts_lembaga' => 'nullable|in:Aktif,Tidak Aktif',
            'jumlah_siswa' => 'nullable|integer',
            'photo' => 'nullable|image',
        ]);
        if ($request->hasFile('photo')) {
            $disk = config('filesystems.default');
            $path = $request->file('photo')->storePublicly('pendidikan_non_formal', $disk);
            if (!empty($pendidikan_non_formal->photo_path)) { Storage::disk($disk)->delete($pendidikan_non_formal->photo_path); }
            try { Storage::disk($disk)->setVisibility($path, 'public'); } catch(\Throwable $e) {}
            $data['photo_path'] = $path;
        }
        unset($data['photo']);
        $pendidikan_non_formal->update($data);
        return redirect()->route('pendidikan_non_formal.index')->with('success','Data pendidikan non-formal diperbarui.');
    }

    public function destroy(PendidikanNonFormal $pendidikan_non_formal)
    {
        $pendidikan_non_formal->delete();
        return redirect()->route('pendidikan_non_formal.index')->with('success','Data pendidikan non-formal dihapus.');
    }
}

