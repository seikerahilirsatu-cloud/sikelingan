<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
 

class PengaduanController extends Controller
{
    public function create()
    {
        return view('pengaduan.form');
    }

    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'anonim' => ['nullable','boolean'],
            'nama' => ['nullable','string','max:100'],
            'kontak' => ['nullable','string','max:100'],
            'kategori' => ['required','string','max:50'],
            'judul' => ['required','string','max:120'],
            'isi' => ['required','string','max:5000'],
            'lokasi' => ['nullable','string','max:200'],
            'lampiran.*' => ['nullable','file','mimes:jpg,jpeg,png,pdf','max:4096'],
            'setuju' => ['accepted'],
        ]);

        $kode = 'PD-' . now()->format('ymd') . '-' . Str::upper(Str::random(6));

        $paths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $paths[] = $file->store('pengaduan/'.$kode, 'public');
            }
        }

        $data = [
            'kode_tiket' => $kode,
            'nama' => $request->boolean('anonim') ? null : ($validated['nama'] ?? null),
            'kontak' => $request->boolean('anonim') ? null : ($validated['kontak'] ?? null),
            'kategori' => $validated['kategori'],
            'judul' => $validated['judul'],
            'isi' => $validated['isi'],
            'lokasi' => $validated['lokasi'] ?? null,
            'lampiran' => $paths,
            'status' => 'baru',
            'ip_address' => $request->ip(),
            'user_agent' => (string)($request->header('User-Agent')),
        ];

        Pengaduan::create($data);

        

        return redirect()->route('pengaduan.cek', ['kode' => $kode])->with('success', 'Pengaduan berhasil dikirim');
    }

    public function cek(Request $request)
    {
        $kode = $request->query('kode');
        $p = null;
        if ($kode) {
            $p = Pengaduan::where('kode_tiket', $kode)->first();
        }
        return view('pengaduan.cek', ['pengaduan' => $p, 'kode' => $kode]);
    }

    public function adminIndex(Request $request)
    {
        $q = Pengaduan::query();
        if ($s = $request->query('status')) { $q->where('status',$s); }
        if ($k = $request->query('kategori')) { $q->where('kategori',$k); }
        $list = $q->latest()->paginate(20);
        return view('admin.pengaduan.index', ['list' => $list]);
    }

    public function adminShow($id)
    {
        $p = Pengaduan::findOrFail($id);
        return view('admin.pengaduan.show', ['p' => $p]);
    }

    public function adminUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => ['required','in:baru,diproses,selesai,ditolak'],
            'handled_notes' => ['nullable','string','max:2000'],
            'public_notes' => ['nullable','string','max:2000'],
        ]);
        $p = Pengaduan::findOrFail($id);
        $p->status = $validated['status'];
        $p->handled_notes = $validated['handled_notes'] ?? null;
        $p->public_notes = $validated['public_notes'] ?? null;
        $p->handled_by = auth()->id();
        $p->handled_at = now();
        $p->save();
        return redirect()->route('admin.pengaduan.show', $p->id)->with('success','Status diperbarui');
    }

    public function adminDestroy($id)
    {
        $p = Pengaduan::findOrFail($id);
        try {
            $lampiran = (array)($p->lampiran ?? []);
            foreach ($lampiran as $path) {
                try { \Illuminate\Support\Facades\Storage::disk('public')->delete($path); } catch(\Throwable $e) {}
            }
            if (!empty($p->kode_tiket)) {
                try { \Illuminate\Support\Facades\Storage::disk('public')->deleteDirectory('pengaduan/'. $p->kode_tiket); } catch(\Throwable $e) {}
            }
        } catch (\Throwable $e) {}
        $p->delete();
        return redirect()->route('admin.pengaduan.index')->with('success','Pengaduan dihapus');
    }
}
