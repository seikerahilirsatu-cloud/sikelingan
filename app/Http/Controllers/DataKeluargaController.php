<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Http\Requests\StoreDataKeluargaRequest;
use App\Http\Requests\UpdateDataKeluargaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DataKeluargaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');
        $query = DataKeluarga::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama_kep','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));

        $user = Auth::user();
        if ($user && $user->role === 'kepala_lingkungan') {
            $query->where('lingkungan', $user->lingkungan);
        }

        $families = $query->orderBy('id','desc')->paginate(12);

        return view('data_keluarga.index', compact('families','q'));
    }

    public function create()
    {
        $user = Auth::user();
        $defaultLingkungan = null;
        if ($user && $user->role === 'kepala_lingkungan') {
            $defaultLingkungan = $user->lingkungan;
        }
        return view('data_keluarga.create', compact('defaultLingkungan'));
    }

    public function store(StoreDataKeluargaRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();
        if ($user && $user->role === 'kepala_lingkungan') {
            // force lingkungan to user's lingkungan to prevent creating outside scope
            $data['lingkungan'] = $user->lingkungan;
        }
        DataKeluarga::create($data);
        return redirect()->route('data_keluarga.index')->with('success','Data keluarga berhasil disimpan.');
    }

    public function show(DataKeluarga $dataKeluarga)
    {
        $family = $dataKeluarga->load('members');
        return view('data_keluarga.show', compact('family'));
    }

    public function edit(DataKeluarga $dataKeluarga)
    {
        return view('data_keluarga.edit', ['family' => $dataKeluarga]);
    }

    public function update(UpdateDataKeluargaRequest $request, DataKeluarga $dataKeluarga)
    {
        $dataKeluarga->update($request->validated());
        // sync members' status_warga if status_keluarga changed
        if ($request->filled('status_keluarga')) {
            \App\Models\BiodataWarga::where('no_kk', $dataKeluarga->no_kk)
                ->update(['status_warga' => $dataKeluarga->status_keluarga]);
        }
        return redirect()->route('data_keluarga.index')->with('success','Data keluarga diperbarui.');
    }

    public function destroy(DataKeluarga $dataKeluarga)
    {
        $dataKeluarga->delete();
        return redirect()->route('data_keluarga.index')->with('success','Data keluarga dihapus.');
    }
}
