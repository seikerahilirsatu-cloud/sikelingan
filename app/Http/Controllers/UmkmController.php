<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $lingkungan = $request->input('lingkungan');
        $query = Umkm::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama_usaha','like',"%$q%")
                  ->orWhere('jenis','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));

        $user = Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) {
            $lingkungan = $user->lingkungan;
        }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') {
            $query->where('lingkungan', $user->lingkungan);
        }

        $items = $query->orderBy('id','desc')->paginate(12);
        return view('umkm.index', ['items' => $items, 'q' => $q, 'lingkungan' => $lingkungan]);
    }

    public function create()
    {
        return view('umkm.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'lingkungan' => 'nullable|string|max:50',
            'status_operasional' => 'nullable|string|max:100',
            'pemilik_nik' => 'nullable|string|max:30',
            'npwp_pemilik' => 'nullable|string|max:30',
            'no_nib' => 'nullable|string|max:30',
            'kontak' => 'nullable|string|max:50',
            'tanggal_berdiri' => 'nullable|date',
            'omzet' => 'nullable|numeric',
            'koordinat_lat' => 'nullable|string|max:50',
            'koordinat_lng' => 'nullable|string|max:50',
            'photo' => 'nullable|image',
        ]);

        $user = Auth::user();
        if ($user && $user->role === 'kepala_lingkungan') {
            $data['lingkungan'] = $user->lingkungan;
        }
        if ($request->hasFile('photo')) {
            $disk = 'public';
            $path = $request->file('photo')->storePublicly('umkm', $disk);
            try { \Illuminate\Support\Facades\Storage::disk($disk)->setVisibility($path, 'public'); } catch(\Throwable $e) {}
            $data['photo_path'] = $path;
        }
        unset($data['photo']);

        Umkm::create($data);
        return redirect()->route('umkm.index')->with('success','Data UMKM berhasil disimpan.');
    }

    public function show(Umkm $umkm)
    {
        return view('umkm.show', ['item' => $umkm]);
    }

    public function edit(Umkm $umkm)
    {
        return view('umkm.edit', ['item' => $umkm]);
    }

    public function update(Request $request, Umkm $umkm)
    {
        $data = $request->validate([
            'nama_usaha' => 'required|string|max:255',
            'jenis' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'lingkungan' => 'nullable|string|max:50',
            'status_operasional' => 'nullable|string|max:100',
            'pemilik_nik' => 'nullable|string|max:30',
            'npwp_pemilik' => 'nullable|string|max:30',
            'no_nib' => 'nullable|string|max:30',
            'kontak' => 'nullable|string|max:50',
            'tanggal_berdiri' => 'nullable|date',
            'omzet' => 'nullable|numeric',
            'koordinat_lat' => 'nullable|string|max:50',
            'koordinat_lng' => 'nullable|string|max:50',
            'photo' => 'nullable|image',
        ]);
        if ($request->hasFile('photo')) {
            $disk = 'public';
            $path = $request->file('photo')->storePublicly('umkm', $disk);
            if (!empty($umkm->photo_path)) {
                Storage::disk($disk)->delete($umkm->photo_path);
            }
            try { Storage::disk($disk)->setVisibility($path, 'public'); } catch(\Throwable $e) {}
            $data['photo_path'] = $path;
        }
        unset($data['photo']);

        $umkm->update($data);
        return redirect()->route('umkm.index')->with('success','Data UMKM diperbarui.');
    }

    public function destroy(Umkm $umkm)
    {
        $umkm->delete();
        return redirect()->route('umkm.index')->with('success','Data UMKM dihapus.');
    }
}
