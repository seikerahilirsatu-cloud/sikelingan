<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Umkm;

class ImportUmkmController extends Controller
{
    public function form()
    {
        return view('import.umkm_form');
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
            $exists = Umkm::where('nama_usaha', $r['nama_usaha'] ?? null)
                ->where('alamat', $r['alamat'] ?? null)->exists();
            $result[] = ['data' => $r, 'action' => $exists ? 'update' : 'create'];
        }
        return view('import.umkm_preview', ['items' => $result]);
    }

    public function commit(Request $request)
    {
        $items = $request->input('items', []);
        $created = 0; $updated = 0; $skipped = 0;
        DB::transaction(function () use ($items, &$created, &$updated, &$skipped) {
            foreach ($items as $it) {
                $data = $it['data'] ?? [];
                $nama = $data['nama_usaha'] ?? null; $alamat = $data['alamat'] ?? null;
                if (!$nama || !$alamat) { $skipped++; continue; }
                $payload = [
                    'jenis' => $data['jenis'] ?? null,
                    'lingkungan' => $data['lingkungan'] ?? null,
                    'status_operasional' => $data['status_operasional'] ?? null,
                    'pemilik_nik' => $data['pemilik_nik'] ?? null,
                    'kontak' => $data['kontak'] ?? null,
                    'tanggal_berdiri' => $data['tanggal_berdiri'] ?? null,
                    'omzet' => isset($data['omzet']) ? (float) $data['omzet'] : null,
                    'koordinat_lat' => $data['koordinat_lat'] ?? null,
                    'koordinat_lng' => $data['koordinat_lng'] ?? null,
                    'photo_path' => $data['photo_path'] ?? null,
                    'npwp_pemilik' => $data['npwp_pemilik'] ?? null,
                    'no_nib' => $data['no_nib'] ?? null,
                ];
                $model = Umkm::where('nama_usaha', $nama)->where('alamat', $alamat)->first();
                if ($model) {
                    $model->update(array_merge(['nama_usaha' => $nama, 'alamat' => $alamat], $payload));
                    $updated++;
                } else {
                    Umkm::create(array_merge(['nama_usaha' => $nama, 'alamat' => $alamat], $payload));
                    $created++;
                }
            }
        });
        return redirect()->route('umkm.index')->with('success', "Import UMKM selesai. Created: $created, Updated: $updated, Skipped: $skipped");
    }

    public function template()
    {
        $filename = 'template_umkm.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama_usaha','jenis','alamat','lingkungan','status_operasional','pemilik_nik','npwp_pemilik','no_nib','kontak','tanggal_berdiri',
            'omzet','koordinat_lat','koordinat_lng','photo_path'
        ];
        $samples = [
            ['Toko Sembako A','Ritel','Jl. Mawar No.1','I','Aktif','','12.345.678.9-012.345','1234567890123','081234567890','2015-01-01','25000000','-0.4501','117.1385',''],
            ['Warung Makan B','Kuliner','Jl. Melati No.2','II','Aktif','','','','081298765432','2018-06-12','15000000','-0.4512','117.1396',''],
        ];
        return response()->stream(function () use ($columns, $samples) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            foreach ($samples as $row) { fputcsv($out, $row); }
            fclose($out);
        }, 200, $headers);
    }
}