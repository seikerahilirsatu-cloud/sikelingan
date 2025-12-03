<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PendidikanFormal;

class ImportPendidikanFormalController extends Controller
{
    public function form()
    {
        return view('import.pendidikan_formal_form');
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
            $exists = PendidikanFormal::where('nama_sekolah', $r['nama_sekolah'] ?? null)
                ->where('alamat', $r['alamat'] ?? null)->exists();
            $result[] = ['data' => $r, 'action' => $exists ? 'update' : 'create'];
        }
        return view('import.pendidikan_formal_preview', ['items' => $result]);
    }

    public function commit(Request $request)
    {
        $items = $request->input('items', []);
        $created = 0; $updated = 0; $skipped = 0;
        DB::transaction(function () use ($items, &$created, &$updated, &$skipped) {
            foreach ($items as $it) {
                $data = $it['data'] ?? [];
                $nama = $data['nama_sekolah'] ?? null; $alamat = $data['alamat'] ?? null;
                if (!$nama || !$alamat) { $skipped++; continue; }
                $payload = [
                    'jenjang' => $data['jenjang'] ?? null,
                    'jenis_sekolah' => $data['jenis_sekolah'] ?? null,
                    'tahun_berdiri' => isset($data['tahun_berdiri']) ? (int)$data['tahun_berdiri'] : null,
                    'sk_pendirian' => $data['sk_pendirian'] ?? null,
                    'lingkungan' => $data['lingkungan'] ?? null,
                    'photo_path' => $data['foto_sekolah'] ?? ($data['photo_path'] ?? null),
                    'stts_sekolah' => $data['stts_sekolah'] ?? null,
                    'jlh_ruang_kelas' => isset($data['jlh_ruang_kelas']) ? (int)$data['jlh_ruang_kelas'] : null,
                    'jlh_perpustakaan' => isset($data['jlh_perpustakaan']) ? (int)$data['jlh_perpustakaan'] : null,
                    'jlh_lab' => isset($data['jlh_lab']) ? (int)$data['jlh_lab'] : null,
                    'jlh_wc' => isset($data['jlh_wc']) ? (int)$data['jlh_wc'] : null,
                    'kantin' => $data['kantin'] ?? null,
                    'nama_kep_sekolah' => $data['nama_kep_sekolah'] ?? null,
                    'jlh_guru_pegawai' => isset($data['jlh_guru_pegawai']) ? (int)$data['jlh_guru_pegawai'] : null,
                    'jlh_guru_honor' => isset($data['jlh_guru_honor']) ? (int)$data['jlh_guru_honor'] : null,
                    'jumlah_siswa' => isset($data['jumlah_siswa']) ? (int)$data['jumlah_siswa'] : null,
                ];
                $model = PendidikanFormal::where('nama_sekolah', $nama)->where('alamat', $alamat)->first();
                if ($model) { $model->update(array_merge(['nama_sekolah' => $nama, 'alamat' => $alamat], $payload)); $updated++; }
                else { PendidikanFormal::create(array_merge(['nama_sekolah' => $nama, 'alamat' => $alamat], $payload)); $created++; }
            }
        });
        return redirect()->route('pendidikan_formal.index')->with('success', "Import pendidikan formal selesai. Created: $created, Updated: $updated, Skipped: $skipped");
    }

    public function template()
    {
        $filename = 'template_pendidikan_formal.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama_sekolah','jenjang','jenis_sekolah','tahun_berdiri','sk_pendirian','alamat','lingkungan','foto_sekolah','stts_sekolah','jlh_ruang_kelas','jlh_perpustakaan','jlh_lab','jlh_wc','kantin','nama_kep_sekolah','jlh_guru_pegawai','jlh_guru_honor','jumlah_siswa'
        ];
        $samples = [
            ['SD Negeri 01','SD','Negeri','1990','SK-123','Jl. Mawar No.1','I','','Aktif','12','1','2','8','Ada','Budi','25','10','320'],
            ['SMA Swasta Budi','SLTA','Swasta','2005','SK-456','Jl. Melati No.2','II','','Aktif','18','1','3','20','Tidak Ada','Sari','40','15','780'],
        ];
        return response()->stream(function () use ($columns, $samples) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            foreach ($samples as $row) { fputcsv($out, $row); }
            fclose($out);
        }, 200, $headers);
    }
}

