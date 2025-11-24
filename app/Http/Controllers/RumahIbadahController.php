<?php

namespace App\Http\Controllers;

use App\Models\RumahIbadah;
use App\Http\Requests\StoreRumahIbadahRequest;
use App\Http\Requests\UpdateRumahIbadahRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RumahIbadahController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $jenis = $request->input('jenis');
        $status = $request->input('status');
        $lingkungan = $request->input('lingkungan');
        $query = RumahIbadah::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama','like',"%$q%")
                  ->orWhere('jenis','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }))
            ->when($jenis, fn($qb) => $qb->where('jenis',$jenis))
            ->when($status, fn($qb) => $qb->where('status_operasional',$status));

        $user = Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) {
            $lingkungan = $user->lingkungan;
        }
        if ($lingkungan) {
            $query->where('lingkungan', $lingkungan);
        }
        if ($user && $user->role === 'kepala_lingkungan') {
            $query->where('lingkungan', $user->lingkungan);
        }

        $places = $query->orderBy('id','desc')->paginate(12);
        return view('rumah_ibadah.index', compact('places','q','jenis','status','lingkungan'));
    }

    public function create()
    {
        return view('rumah_ibadah.create');
    }

    public function store(StoreRumahIbadahRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        if ($user && $user->role === 'kepala_lingkungan') {
            $data['lingkungan'] = $user->lingkungan;
        }
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('rumah_ibadah', 'public');
            $data['photo_path'] = $path;
        }
        RumahIbadah::create($data);
        return redirect()->route('rumah_ibadah.index')->with('success','Data rumah ibadah berhasil disimpan.');
    }

    public function show(RumahIbadah $rumahIbadah)
    {
        return view('rumah_ibadah.show', ['place' => $rumahIbadah]);
    }

    public function edit(RumahIbadah $rumahIbadah)
    {
        return view('rumah_ibadah.edit', ['place' => $rumahIbadah]);
    }

    public function update(UpdateRumahIbadahRequest $request, RumahIbadah $rumahIbadah)
    {
        $data = $request->validated();
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('rumah_ibadah', 'public');
            if (!empty($rumahIbadah->photo_path)) {
                Storage::disk('public')->delete($rumahIbadah->photo_path);
            }
            $data['photo_path'] = $path;
        }
        $rumahIbadah->update($data);
        return redirect()->route('rumah_ibadah.index')->with('success','Data rumah ibadah diperbarui.');
    }

    public function destroy(RumahIbadah $rumahIbadah)
    {
        $rumahIbadah->delete();
        return redirect()->route('rumah_ibadah.index')->with('success','Data rumah ibadah dihapus.');
    }
}