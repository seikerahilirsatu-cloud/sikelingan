<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use App\Models\BiodataWarga;
use App\Models\RumahIbadah;
use App\Models\Umkm;
use App\Models\PendidikanFormal;
use App\Models\PendidikanNonFormal;

class ExportController extends Controller
{
    public function biodata(Request $request)
    {
        $q = $request->input('q');
        $query = BiodataWarga::query();
        if ($q) {
            $query->where(function ($qb) use ($q) {
                $qb->where('nik', 'like', "%$q%")
                   ->orWhere('nama_lgkp', 'like', "%$q%")
                   ->orWhere('no_kk', 'like', "%$q%");
            });
        }

        $user = Auth::user();
        if ($user && !empty($user->lingkungan)) {
            if (Schema::hasColumn('biodata_warga', 'lingkungan')) {
                $query->where('lingkungan', $user->lingkungan);
            } else {
                $query->whereHas('family', function ($q2) use ($user) {
                    $q2->where('lingkungan', $user->lingkungan);
                });
            }
        }

        $filename = 'biodata_warga_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nik',
            'nama_lgkp',
            'no_kk',
            'jenis_kelamin',
            'tgl_lhr',
            'agama',
            'pendidikan_terakhir',
            'pekerjaan',
            'stts_kawin',
            'stts_hub_keluarga',
            'status_warga',
            'flag_status',
        ];

        return response()->stream(function () use ($query, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $query->orderBy('id', 'desc')->chunk(500, function ($rows) use ($out, $columns) {
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $col) {
                        $row[] = $r->{$col};
                    }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, 200, $headers);
    }

    public function rumahIbadah(Request $request)
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

        $filename = 'rumah_ibadah_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama','jenis','alamat','lingkungan','status_operasional','kapasitas','tanggal_berdiri',
            'pengurus_nik','kontak','koordinat_lat','koordinat_lng','photo_path'
        ];

        return response()->stream(function () use ($query, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $query->orderBy('id','desc')->chunk(500, function ($rows) use ($out, $columns) {
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $col) { $row[] = $r->{$col}; }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, 200, $headers);
    }

    public function umkm(Request $request)
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
        if (!$lingkungan && $user && !empty($user->lingkungan)) { $lingkungan = $user->lingkungan; }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') { $query->where('lingkungan', $user->lingkungan); }

        $filename = 'umkm_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama_usaha','jenis','alamat','lingkungan','status_operasional','pemilik_nik','npwp_pemilik','no_nib','kontak','tanggal_berdiri','omzet',
            'koordinat_lat','koordinat_lng','photo_path'
        ];

        return response()->stream(function () use ($query, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $query->orderBy('id','desc')->chunk(500, function ($rows) use ($out, $columns) {
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $col) { $row[] = $r->{$col}; }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, 200, $headers);
    }

    public function keluarga(Request $request)
    {
        $q = $request->input('q');
        $lingkungan = $request->input('lingkungan');
        $query = \App\Models\DataKeluarga::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('no_kk','like',"%$q%")
                  ->orWhere('nama_kep','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) { $lingkungan = $user->lingkungan; }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') { $query->where('lingkungan', $user->lingkungan); }

        $filename = 'data_keluarga_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = ['no_kk','nama_kep','alamat','lingkungan','status_keluarga'];

        return response()->stream(function () use ($query, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $query->orderBy('id','desc')->chunk(500, function ($rows) use ($out, $columns) {
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $col) { $row[] = $r->{$col}; }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, 200, $headers);
    }

    public function pendidikanFormal(Request $request)
    {
        $q = $request->input('q');
        $lingkungan = $request->input('lingkungan');
        $query = PendidikanFormal::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama_sekolah','like',"%$q%")
                  ->orWhere('jenjang','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) { $lingkungan = $user->lingkungan; }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') { $query->where('lingkungan', $user->lingkungan); }

        $filename = 'pendidikan_formal_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama_sekolah','jenjang','jenis_sekolah','tahun_berdiri','sk_pendirian','alamat','lingkungan','photo_path','stts_sekolah','jlh_ruang_kelas','jlh_perpustakaan','jlh_lab','jlh_wc','kantin','nama_kep_sekolah','jlh_guru_pegawai','jlh_guru_honor','jumlah_siswa'
        ];

        return response()->stream(function () use ($query, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $query->orderBy('id','desc')->chunk(500, function ($rows) use ($out, $columns) {
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $col) { $row[] = $r->{$col}; }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, 200, $headers);
    }

    public function pendidikanNonFormal(Request $request)
    {
        $q = $request->input('q');
        $lingkungan = $request->input('lingkungan');
        $query = PendidikanNonFormal::query()
            ->when($q, fn($qb) => $qb->where(function($w) use ($q) {
                $w->where('nama_lembaga','like',"%$q%")
                  ->orWhere('bidang_pelatihan','like',"%$q%")
                  ->orWhere('alamat','like',"%$q%");
            }));

        $user = \Illuminate\Support\Facades\Auth::user();
        if (!$lingkungan && $user && !empty($user->lingkungan)) { $lingkungan = $user->lingkungan; }
        if ($lingkungan) { $query->where('lingkungan', $lingkungan); }
        if ($user && $user->role === 'kepala_lingkungan') { $query->where('lingkungan', $user->lingkungan); }

        $filename = 'pendidikan_non_formal_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        $columns = [
            'nama_lembaga','bidang_pelatihan','tahun_berdiri','sk_pendirian','alamat','no_kontak','lingkungan','nama_pemilik','photo_path','stts_lembaga','jumlah_siswa'
        ];

        return response()->stream(function () use ($query, $columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            $query->orderBy('id','desc')->chunk(500, function ($rows) use ($out, $columns) {
                foreach ($rows as $r) {
                    $row = [];
                    foreach ($columns as $col) { $row[] = $r->{$col}; }
                    fputcsv($out, $row);
                }
            });
            fclose($out);
        }, 200, $headers);
    }

    public function pendidikanFormalExcel(Request $request)
    {
        $rows = PendidikanFormal::orderBy('id','desc')->get();
        $html = '<html><head><meta charset="utf-8" /></head><body><table border="1">';
        $html .= '<tr><th>Nama Sekolah</th><th>Jenjang</th><th>Jenis</th><th>Tahun Berdiri</th><th>SK</th><th>Alamat</th><th>Lingkungan</th><th>Status</th><th>Ruang</th><th>Perpus</th><th>Lab</th><th>WC</th><th>Kantin</th><th>Kepala</th><th>Guru/Peg</th><th>Guru Honor</th><th>Siswa</th></tr>';
        foreach ($rows as $r) {
            $html .= '<tr>'
                . '<td>'.htmlspecialchars($r->nama_sekolah).'</td>'
                . '<td>'.htmlspecialchars($r->jenjang).'</td>'
                . '<td>'.htmlspecialchars($r->jenis_sekolah).'</td>'
                . '<td>'.htmlspecialchars($r->tahun_berdiri).'</td>'
                . '<td>'.htmlspecialchars($r->sk_pendirian).'</td>'
                . '<td>'.htmlspecialchars($r->alamat).'</td>'
                . '<td>'.htmlspecialchars($r->lingkungan).'</td>'
                . '<td>'.htmlspecialchars($r->stts_sekolah).'</td>'
                . '<td>'.htmlspecialchars($r->jlh_ruang_kelas).'</td>'
                . '<td>'.htmlspecialchars($r->jlh_perpustakaan).'</td>'
                . '<td>'.htmlspecialchars($r->jlh_lab).'</td>'
                . '<td>'.htmlspecialchars($r->jlh_wc).'</td>'
                . '<td>'.htmlspecialchars($r->kantin).'</td>'
                . '<td>'.htmlspecialchars($r->nama_kep_sekolah).'</td>'
                . '<td>'.htmlspecialchars($r->jlh_guru_pegawai).'</td>'
                . '<td>'.htmlspecialchars($r->jlh_guru_honor).'</td>'
                . '<td>'.htmlspecialchars($r->jumlah_siswa).'</td>'
                . '</tr>';
        }
        $html .= '</table></body></html>';
        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="pendidikan_formal_'. now()->format('Ymd_His') .'.xls"',
        ]);
    }

    public function pendidikanNonFormalExcel(Request $request)
    {
        $rows = PendidikanNonFormal::orderBy('id','desc')->get();
        $html = '<html><head><meta charset="utf-8" /></head><body><table border="1">';
        $html .= '<tr><th>Nama Lembaga</th><th>Bidang</th><th>Tahun Berdiri</th><th>SK</th><th>Alamat</th><th>No. Kontak</th><th>Lingkungan</th><th>Pemilik</th><th>Status</th><th>Siswa</th></tr>';
        foreach ($rows as $r) {
            $html .= '<tr>'
                . '<td>'.htmlspecialchars($r->nama_lembaga).'</td>'
                . '<td>'.htmlspecialchars($r->bidang_pelatihan).'</td>'
                . '<td>'.htmlspecialchars($r->tahun_berdiri).'</td>'
                . '<td>'.htmlspecialchars($r->sk_pendirian).'</td>'
                . '<td>'.htmlspecialchars($r->alamat).'</td>'
                . '<td>'.htmlspecialchars($r->no_kontak).'</td>'
                . '<td>'.htmlspecialchars($r->lingkungan).'</td>'
                . '<td>'.htmlspecialchars($r->nama_pemilik).'</td>'
                . '<td>'.htmlspecialchars($r->stts_lembaga).'</td>'
                . '<td>'.htmlspecialchars($r->jumlah_siswa).'</td>'
                . '</tr>';
        }
        $html .= '</table></body></html>';
        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="pendidikan_non_formal_'. now()->format('Ymd_His') .'.xls"',
        ]);
    }
}
