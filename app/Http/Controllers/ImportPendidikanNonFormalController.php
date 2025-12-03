<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PendidikanNonFormal;

class ImportPendidikanNonFormalController extends Controller
{
    public function form()
    {
        return view('import.pendidikan_non_formal_form');
    }

    public function preview(Request $request)
    {
        $request->validate(['file' => 'required|file']);
        $file = $request->file('file');
        $rows = [];
        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle, 0, ',');
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                $rows[] = array_combine($header, $data);
            }
            fclose($handle);
        }
        $result = [];
        foreach ($rows as $r) {
            $exists = PendidikanNonFormal::where('nama_lembaga', $r['nama_lembaga'] ?? null)
                ->where('alamat', $r['alamat'] ?? null)->exists();
            $result[] = ['data' => $r, 'action' => $exists ? 'update' : 'create'];
        }
        return view('import.pendidikan_non_formal_preview', ['items' => $result]);
    }

    public function commit(Request $request)
    {
        $items = $request->input('items', []);
        $created = 0; $updated = 0; $skipped = 0;
        DB::transaction(function () use ($items, &$created, &$updated, &$skipped) {
            foreach ($items as $it) {
                $data = $it['data'] ?? [];
                $nama = $data['nama_lembaga'] ?? null; $alamat = $data['alamat'] ?? null;
                if (!$nama || !$alamat) { $skipped++; continue; }
                $payload = [
                    'bidang_pelatihan' => $data['bidang_pelatihan'] ?? null,
                    'tahun_berdiri' => isset($data['tahun_berdiri']) ? (int)$data['tahun_berdiri'] : null,
                    'sk_pendirian' => $data['sk_pendirian'] ?? null,
                    'no_kontak' => $data['no_kontak'] ?? null,
                    'lingkungan' => $data['lingkungan'] ?? null,
                    'nama_pemilik' => $data['nama_pemilik'] ?? null,
                    'photo_path' => $data['foto_lembaga'] ?? ($data['photo_path'] ?? null),
                    'stts_lembaga' => $data['stts_lembaga'] ?? null,
                    'jumlah_siswa' => isset($data['jumlah_siswa']) ? (int)$data['jumlah_siswa'] : null,
                ];
                $model = PendidikanNonFormal::where('nama_lembaga', $nama)->where('alamat', $alamat)->first();
                if ($model) { $model->update(array_merge(['nama_lembaga' => $nama, 'alamat' => $alamat], $payload)); $updated++; }
                else { PendidikanNonFormal::create(array_merge(['nama_lembaga' => $nama, 'alamat' => $alamat], $payload)); $created++; }
            }
        });
        return redirect()->route('pendidikan_non_formal.index')->with('success', "Import pendidikan non-formal selesai. Created: $created, Updated: $updated, Skipped: $skipped");
    }

    public function template()
    {
        $filename = 'template_pendidikan_non_formal.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama_lembaga','bidang_pelatihan','tahun_berdiri','sk_pendirian','alamat','no_kontak','lingkungan','nama_pemilik','foto_lembaga','stts_lembaga','jumlah_siswa'
        ];
        $samples = [
            ['LBB Cerdas','Bimbel','2018','SK-001','Jl. Kenanga No.3','0812345678','I','Andi','','Aktif','120'],
            ['Kursus Bahasa Asing','Bahasa','2020','SK-010','Jl. Dahlia No.5','0812223334','II','Dewi','','Aktif','80'],
        ];
        return response()->stream(function () use ($columns, $samples) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            foreach ($samples as $row) { fputcsv($out, $row); }
            fclose($out);
        }, 200, $headers);
    }
}

