<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\RumahIbadah;

class ImportRumahIbadahController extends Controller
{
    public function form()
    {
        return view('import.rumah_ibadah_form');
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
            $exists = RumahIbadah::where('nama', $r['nama'] ?? null)
                ->where('alamat', $r['alamat'] ?? null)->exists();
            $result[] = ['data' => $r, 'action' => $exists ? 'update' : 'create'];
        }
        return view('import.rumah_ibadah_preview', ['items' => $result]);
    }

    public function commit(Request $request)
    {
        $items = $request->input('items', []);
        $created = 0; $updated = 0; $skipped = 0;
        DB::transaction(function () use ($items, &$created, &$updated, &$skipped) {
            foreach ($items as $it) {
                $data = $it['data'] ?? [];
                $nama = $data['nama'] ?? null; $alamat = $data['alamat'] ?? null;
                if (!$nama || !$alamat) { $skipped++; continue; }
                $payload = [
                    'jenis' => $data['jenis'] ?? null,
                    'lingkungan' => $data['lingkungan'] ?? null,
                    'status_operasional' => $data['status_operasional'] ?? null,
                    'kapasitas' => isset($data['kapasitas']) ? (int) $data['kapasitas'] : null,
                    'tanggal_berdiri' => $data['tanggal_berdiri'] ?? null,
                    'pengurus_nik' => $data['pengurus_nik'] ?? null,
                    'kontak' => $data['kontak'] ?? null,
                    'koordinat_lat' => $data['koordinat_lat'] ?? null,
                    'koordinat_lng' => $data['koordinat_lng'] ?? null,
                    'photo_path' => $data['photo_path'] ?? null,
                ];
                $model = RumahIbadah::where('nama', $nama)->where('alamat', $alamat)->first();
                if ($model) {
                    $model->update(array_merge(['nama' => $nama, 'alamat' => $alamat], $payload));
                    $updated++;
                } else {
                    RumahIbadah::create(array_merge(['nama' => $nama, 'alamat' => $alamat], $payload));
                    $created++;
                }
            }
        });
        return redirect()->route('rumah_ibadah.index')->with('success', "Import selesai. Created: $created, Updated: $updated, Skipped: $skipped");
    }

    public function template()
    {
        $filename = 'template_rumah_ibadah.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama','jenis','alamat','lingkungan','status_operasional','kapasitas','tanggal_berdiri',
            'pengurus_nik','kontak','koordinat_lat','koordinat_lng','photo_path'
        ];
        $samples = [
            [
                'Masjid Al-Falah','Masjid','Jl. Merdeka No. 10','I','Aktif','300','2010-05-01','',
                '081234567890','-0.4501234','117.1385678',''
            ],
            [
                'Gereja Gloria','Gereja','Jl. Sudirman No. 45','II','Aktif','250','2005-09-12','',
                '081298765432','-0.4512345','117.1396789',''
            ],
            [
                'Vihara Dharma','Vihara','Jl. Diponegoro No. 7','III','Tidak Aktif','120','1998-03-22','',
                '085212345678','-0.4523456','117.1407890',''
            ],
        ];
        return response()->stream(function () use ($columns, $samples) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            foreach ($samples as $row) { fputcsv($out, $row); }
            fclose($out);
        }, 200, $headers);
    }
}