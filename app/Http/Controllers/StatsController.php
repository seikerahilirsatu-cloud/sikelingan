<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiodataWarga;
use App\Models\DataKeluarga;
use App\Models\RumahIbadah;
use App\Models\Umkm;

class StatsController extends Controller
{
    public function penduduk(Request $request)
    {
        $totalWarga = BiodataWarga::count();
        $totalKeluarga = DataKeluarga::count();

        $totalLaki = BiodataWarga::whereIn('jenis_kelamin', ['L','LAKI-LAKI','Laki-laki','laki-laki'])->count();
        $totalPerempuan = BiodataWarga::whereIn('jenis_kelamin', ['P','PEREMPUAN','Perempuan','perempuan'])->count();
        $genderLabels = ['Pria','Wanita'];
        $genderDataChart = [$totalLaki, $totalPerempuan];

        // Age groups using MySQL TIMESTAMPDIFF
        $ageBuckets = [
            ['label' => '0-4',  'min' => 0,  'max' => 4],
            ['label' => '5-9',  'min' => 5,  'max' => 9],
            ['label' => '10-14','min' => 10, 'max' => 14],
            ['label' => '15-19','min' => 15, 'max' => 19],
            ['label' => '20-24','min' => 20, 'max' => 24],
            ['label' => '25-29','min' => 25, 'max' => 29],
            ['label' => '30-34','min' => 30, 'max' => 34],
            ['label' => '35-39','min' => 35, 'max' => 39],
            ['label' => '40-44','min' => 40, 'max' => 44],
            ['label' => '45-49','min' => 45, 'max' => 49],
            ['label' => '50-54','min' => 50, 'max' => 54],
            ['label' => '55-59','min' => 55, 'max' => 59],
            ['label' => '60+',  'min' => 60, 'max' => null],
        ];
        $ageLabels = array_map(fn($b) => $b['label'], $ageBuckets);
        $ageData = [];
        foreach ($ageBuckets as $b) {
            $q = BiodataWarga::query();
            $q->whereNotNull('tgl_lhr');
            if ($b['max'] === null) {
                $q->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lhr, CURDATE()) >= ?', [$b['min']]);
            } else {
                $q->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lhr, CURDATE()) BETWEEN ? AND ?', [$b['min'], $b['max']]);
            }
            $ageData[] = $q->count();
        }

        // Religion with ordered labels from config
        $agamaOrdered = config('biodata_config.agama', []);
        $agamaRaw = BiodataWarga::selectRaw('COALESCE(NULLIF(agama, ""), "Lainnya") as label')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('label')
            ->get();
        $mapAgama = [];
        foreach ($agamaRaw as $row) { $mapAgama[trim($row->label)] = (int)($row->total ?? 0); }
        $agamaLabels = []; $agamaData = []; $lainnyaSum = 0;
        foreach ($agamaOrdered as $lbl) {
            $agamaLabels[] = $lbl;
            $agamaData[] = $mapAgama[$lbl] ?? 0;
            unset($mapAgama[$lbl]);
        }
        foreach ($mapAgama as $lbl => $cnt) { $lainnyaSum += $cnt; }
        $agamaLabels[] = 'Lainnya';
        $agamaData[] = $lainnyaSum;

        // Education ordered by config
        $eduOrdered = config('biodata_config.pendidikan_terakhir', []);
        $eduRaw = BiodataWarga::selectRaw('COALESCE(NULLIF(pendidikan_terakhir, ""), "Tidak diketahui") as label')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('label')
            ->get();
        $mapEdu = [];
        foreach ($eduRaw as $row) { $mapEdu[trim($row->label)] = (int)($row->total ?? 0); }
        $eduLabels = []; $eduData = []; $unknownEdu = 0;
        foreach ($eduOrdered as $lbl) {
            $eduLabels[] = $lbl;
            $eduData[] = $mapEdu[$lbl] ?? 0;
            unset($mapEdu[$lbl]);
        }
        foreach ($mapEdu as $lbl => $cnt) { $unknownEdu += $cnt; }
        $eduLabels[] = 'Tidak diketahui';
        $eduData[] = $unknownEdu;

        // Occupation ordered by config
        $jobOrdered = config('biodata_config.pekerjaan', []);
        $jobRaw = BiodataWarga::selectRaw('COALESCE(NULLIF(pekerjaan, ""), "Tidak diketahui") as label')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('label')
            ->get();
        $mapJob = [];
        foreach ($jobRaw as $row) { $mapJob[trim($row->label)] = (int)($row->total ?? 0); }
        $jobLabels = []; $jobData = []; $unknownJob = 0;
        foreach ($jobOrdered as $lbl) {
            $jobLabels[] = $lbl;
            $jobData[] = $mapJob[$lbl] ?? 0;
            unset($mapJob[$lbl]);
        }
        foreach ($mapJob as $lbl => $cnt) { $unknownJob += $cnt; }
        $jobLabels[] = 'Tidak diketahui';
        $jobData[] = $unknownJob;

        return view('stats.penduduk', compact(
            'totalWarga','totalKeluarga','genderLabels','genderDataChart',
            'ageLabels','ageData','agamaLabels','agamaData','eduLabels','eduData','jobLabels','jobData'
        ));
    }

    public function ibadah(Request $request)
    {
        $totalIbadah = RumahIbadah::count();
        $ibadahByJenis = RumahIbadah::select('jenis')->selectRaw('COUNT(*) as total')->groupBy('jenis')->orderBy('jenis')->get();
        $jenisIbadahAll = ['Masjid','Gereja','Pura','Vihara','Klenteng','Mushalla','Lainnya'];
        $countsIbadahNorm = [];
        foreach ($ibadahByJenis as $row) { $countsIbadahNorm[strtolower(trim($row->jenis ?? ''))] = (int)($row->total ?? 0); }
        $ibadahDataArr = array_map(function($j) use ($countsIbadahNorm) { $key = strtolower(trim($j)); return $countsIbadahNorm[$key] ?? 0; }, $jenisIbadahAll);

        return view('stats.ibadah', compact('totalIbadah','jenisIbadahAll','ibadahDataArr'));
    }

    public function umkm(Request $request)
    {
        $totalUmkm = Umkm::count();
        $umkmByJenis = Umkm::selectRaw('COALESCE(NULLIF(jenis, ""), "Tidak diketahui") as jenis')->selectRaw('COUNT(*) as total')->groupBy('jenis')->orderBy('jenis')->get();
        $jenisUmkmAll = array_values(array_unique(array_merge(config('app_local.umkm_jenis', []), ['Tidak diketahui'])));
        $countsUmkmNorm = [];
        foreach ($umkmByJenis as $row) { $countsUmkmNorm[strtolower(trim($row->jenis ?? ''))] = (int)($row->total ?? 0); }
        $umkmDataArr = array_map(function($j) use ($countsUmkmNorm) { $key = strtolower(trim($j)); return $countsUmkmNorm[$key] ?? 0; }, $jenisUmkmAll);

        return view('stats.umkm', compact('totalUmkm','jenisUmkmAll','umkmDataArr'));
    }

    public function pendidikan(Request $request)
    {
        return view('stats.pendidikan');
    }

    public function olahraga(Request $request)
    {
        return view('stats.olahraga');
    }

    public function pasar(Request $request)
    {
        return view('stats.pasar');
    }

    public function mutasi(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        if (!$start || !$end) {
            $end = now()->toDateString();
            $start = now()->startOfMonth()->toDateString();
        }

        $lingkungans = config('app_local.lingkungan_opts', []);
        $rows = [];
        foreach ($lingkungans as $l) {
            $rows[$l] = [
                'lahir_L' => 0,
                'lahir_P' => 0,
                'meninggal_L' => 0,
                'meninggal_P' => 0,
                'masuk_L' => 0,
                'masuk_P' => 0,
                'keluar_L' => 0,
                'keluar_P' => 0,
            ];
        }

        $male = ['L','LAKI-LAKI','Laki-laki','laki-laki','Pria','pria'];
        $female = ['P','PEREMPUAN','Perempuan','perempuan','Wanita','wanita'];

        $lahirL = BiodataWarga::whereBetween('tgl_lhr', [$start, $end])
            ->whereIn('jenis_kelamin', $male)
            ->select('lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('lingkungan')
            ->get();
        foreach ($lahirL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['lahir_L'] = (int)($r->total ?? 0); }
        $lahirP = BiodataWarga::whereBetween('tgl_lhr', [$start, $end])
            ->whereIn('jenis_kelamin', $female)
            ->select('lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('lingkungan')
            ->get();
        foreach ($lahirP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['lahir_P'] = (int)($r->total ?? 0); }

        $meninggalL = \App\Models\WargaMeninggal::join('biodata_warga as bw', 'warga_meninggal.warga_id', '=', 'bw.id')
            ->whereBetween('warga_meninggal.tanggal_meninggal', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('warga_meninggal.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('warga_meninggal.lingkungan')
            ->get();
        foreach ($meninggalL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['meninggal_L'] = (int)($r->total ?? 0); }
        $meninggalP = \App\Models\WargaMeninggal::join('biodata_warga as bw', 'warga_meninggal.warga_id', '=', 'bw.id')
            ->whereBetween('warga_meninggal.tanggal_meninggal', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('warga_meninggal.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('warga_meninggal.lingkungan')
            ->get();
        foreach ($meninggalP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['meninggal_P'] = (int)($r->total ?? 0); }

        $masukL = \App\Models\PindahMasuk::join('biodata_warga as bw', 'pindah_masuk.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_masuk.tanggal_masuk', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('pindah_masuk.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_masuk.lingkungan')
            ->get();
        foreach ($masukL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['masuk_L'] = (int)($r->total ?? 0); }
        $masukP = \App\Models\PindahMasuk::join('biodata_warga as bw', 'pindah_masuk.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_masuk.tanggal_masuk', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('pindah_masuk.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_masuk.lingkungan')
            ->get();
        foreach ($masukP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['masuk_P'] = (int)($r->total ?? 0); }

        $keluarL = \App\Models\PindahKeluar::join('biodata_warga as bw', 'pindah_keluar.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_keluar.tanggal_pindah', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('pindah_keluar.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_keluar.lingkungan')
            ->get();
        foreach ($keluarL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['keluar_L'] = (int)($r->total ?? 0); }
        $keluarP = \App\Models\PindahKeluar::join('biodata_warga as bw', 'pindah_keluar.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_keluar.tanggal_pindah', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('pindah_keluar.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_keluar.lingkungan')
            ->get();
        foreach ($keluarP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['keluar_P'] = (int)($r->total ?? 0); }

        $lingkunganLabels = $lingkungans;
        return view('stats.mutasi', compact('start','end','rows','lingkunganLabels'));
    }

    public function exportMutasiCsv(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        if (!$start || !$end) {
            $end = now()->toDateString();
            $start = now()->startOfMonth()->toDateString();
        }

        $lingkungans = config('app_local.lingkungan_opts', []);
        $rows = [];
        foreach ($lingkungans as $l) {
            $rows[$l] = [
                'lahir_L' => 0,
                'lahir_P' => 0,
                'meninggal_L' => 0,
                'meninggal_P' => 0,
                'masuk_L' => 0,
                'masuk_P' => 0,
                'keluar_L' => 0,
                'keluar_P' => 0,
            ];
        }

        $male = ['L','LAKI-LAKI','Laki-laki','laki-laki','Pria','pria'];
        $female = ['P','PEREMPUAN','Perempuan','perempuan','Wanita','wanita'];

        $lahirL = BiodataWarga::whereBetween('tgl_lhr', [$start, $end])
            ->whereIn('jenis_kelamin', $male)
            ->select('lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('lingkungan')
            ->get();
        foreach ($lahirL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['lahir_L'] = (int)($r->total ?? 0); }
        $lahirP = BiodataWarga::whereBetween('tgl_lhr', [$start, $end])
            ->whereIn('jenis_kelamin', $female)
            ->select('lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('lingkungan')
            ->get();
        foreach ($lahirP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['lahir_P'] = (int)($r->total ?? 0); }

        $meninggalL = \App\Models\WargaMeninggal::join('biodata_warga as bw', 'warga_meninggal.warga_id', '=', 'bw.id')
            ->whereBetween('warga_meninggal.tanggal_meninggal', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('warga_meninggal.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('warga_meninggal.lingkungan')
            ->get();
        foreach ($meninggalL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['meninggal_L'] = (int)($r->total ?? 0); }
        $meninggalP = \App\Models\WargaMeninggal::join('biodata_warga as bw', 'warga_meninggal.warga_id', '=', 'bw.id')
            ->whereBetween('warga_meninggal.tanggal_meninggal', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('warga_meninggal.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('warga_meninggal.lingkungan')
            ->get();
        foreach ($meninggalP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['meninggal_P'] = (int)($r->total ?? 0); }

        $masukL = \App\Models\PindahMasuk::join('biodata_warga as bw', 'pindah_masuk.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_masuk.tanggal_masuk', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('pindah_masuk.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_masuk.lingkungan')
            ->get();
        foreach ($masukL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['masuk_L'] = (int)($r->total ?? 0); }
        $masukP = \App\Models\PindahMasuk::join('biodata_warga as bw', 'pindah_masuk.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_masuk.tanggal_masuk', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('pindah_masuk.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_masuk.lingkungan')
            ->get();
        foreach ($masukP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['masuk_P'] = (int)($r->total ?? 0); }

        $keluarL = \App\Models\PindahKeluar::join('biodata_warga as bw', 'pindah_keluar.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_keluar.tanggal_pindah', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('pindah_keluar.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_keluar.lingkungan')
            ->get();
        foreach ($keluarL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['keluar_L'] = (int)($r->total ?? 0); }
        $keluarP = \App\Models\PindahKeluar::join('biodata_warga as bw', 'pindah_keluar.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_keluar.tanggal_pindah', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('pindah_keluar.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_keluar.lingkungan')
            ->get();
        foreach ($keluarP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['keluar_P'] = (int)($r->total ?? 0); }

        return response()->stream(function () use ($rows, $lingkungans, $start, $end) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Lingkungan','Lahir L','Lahir P','Meninggal L','Meninggal P','Masuk L','Masuk P','Keluar L','Keluar P']);
            foreach ($lingkungans as $l) {
                $r = $rows[$l] ?? ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0];
                fputcsv($handle, [$l, $r['lahir_L'], $r['lahir_P'], $r['meninggal_L'], $r['meninggal_P'], $r['masuk_L'], $r['masuk_P'], $r['keluar_L'], $r['keluar_P']]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan_mutasi_penduduk_' . $start . '_' . $end . '.csv"',
        ]);
    }

    public function exportMutasiExcel(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        if (!$start || !$end) {
            $end = now()->toDateString();
            $start = now()->startOfMonth()->toDateString();
        }

        $lingkungans = config('app_local.lingkungan_opts', []);
        $rows = [];
        foreach ($lingkungans as $l) {
            $rows[$l] = [
                'lahir_L' => 0,
                'lahir_P' => 0,
                'meninggal_L' => 0,
                'meninggal_P' => 0,
                'masuk_L' => 0,
                'masuk_P' => 0,
                'keluar_L' => 0,
                'keluar_P' => 0,
            ];
        }

        $male = ['L','LAKI-LAKI','Laki-laki','laki-laki','Pria','pria'];
        $female = ['P','PEREMPUAN','Perempuan','perempuan','Wanita','wanita'];

        $lahirL = BiodataWarga::whereBetween('tgl_lhr', [$start, $end])
            ->whereIn('jenis_kelamin', $male)
            ->select('lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('lingkungan')
            ->get();
        foreach ($lahirL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['lahir_L'] = (int)($r->total ?? 0); }
        $lahirP = BiodataWarga::whereBetween('tgl_lhr', [$start, $end])
            ->whereIn('jenis_kelamin', $female)
            ->select('lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('lingkungan')
            ->get();
        foreach ($lahirP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['lahir_P'] = (int)($r->total ?? 0); }

        $meninggalL = \App\Models\WargaMeninggal::join('biodata_warga as bw', 'warga_meninggal.warga_id', '=', 'bw.id')
            ->whereBetween('warga_meninggal.tanggal_meninggal', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('warga_meninggal.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('warga_meninggal.lingkungan')
            ->get();
        foreach ($meninggalL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['meninggal_L'] = (int)($r->total ?? 0); }
        $meninggalP = \App\Models\WargaMeninggal::join('biodata_warga as bw', 'warga_meninggal.warga_id', '=', 'bw.id')
            ->whereBetween('warga_meninggal.tanggal_meninggal', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('warga_meninggal.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('warga_meninggal.lingkungan')
            ->get();
        foreach ($meninggalP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['meninggal_P'] = (int)($r->total ?? 0); }

        $masukL = \App\Models\PindahMasuk::join('biodata_warga as bw', 'pindah_masuk.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_masuk.tanggal_masuk', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('pindah_masuk.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_masuk.lingkungan')
            ->get();
        foreach ($masukL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['masuk_L'] = (int)($r->total ?? 0); }
        $masukP = \App\Models\PindahMasuk::join('biodata_warga as bw', 'pindah_masuk.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_masuk.tanggal_masuk', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('pindah_masuk.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_masuk.lingkungan')
            ->get();
        foreach ($masukP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['masuk_P'] = (int)($r->total ?? 0); }

        $keluarL = \App\Models\PindahKeluar::join('biodata_warga as bw', 'pindah_keluar.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_keluar.tanggal_pindah', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $male)
            ->select('pindah_keluar.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_keluar.lingkungan')
            ->get();
        foreach ($keluarL as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['keluar_L'] = (int)($r->total ?? 0); }
        $keluarP = \App\Models\PindahKeluar::join('biodata_warga as bw', 'pindah_keluar.warga_id', '=', 'bw.id')
            ->whereBetween('pindah_keluar.tanggal_pindah', [$start, $end])
            ->whereIn('bw.jenis_kelamin', $female)
            ->select('pindah_keluar.lingkungan')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('pindah_keluar.lingkungan')
            ->get();
        foreach ($keluarP as $r) { $key = $r->lingkungan ?: '-'; if (!isset($rows[$key])) $rows[$key] = ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0]; $rows[$key]['keluar_P'] = (int)($r->total ?? 0); }

        $html = '<html><head><meta charset="utf-8" /></head><body>';
        $html .= '<table border="1">';
        $html .= '<tr><th>Lingkungan</th><th>Lahir L</th><th>Lahir P</th><th>Meninggal L</th><th>Meninggal P</th><th>Masuk L</th><th>Masuk P</th><th>Keluar L</th><th>Keluar P</th></tr>';
        foreach ($lingkungans as $l) {
            $r = $rows[$l] ?? ['lahir_L'=>0,'lahir_P'=>0,'meninggal_L'=>0,'meninggal_P'=>0,'masuk_L'=>0,'masuk_P'=>0,'keluar_L'=>0,'keluar_P'=>0];
            $html .= '<tr>';
            $html .= '<td>'.htmlspecialchars($l).'</td>';
            $html .= '<td>'.$r['lahir_L'].'</td>';
            $html .= '<td>'.$r['lahir_P'].'</td>';
            $html .= '<td>'.$r['meninggal_L'].'</td>';
            $html .= '<td>'.$r['meninggal_P'].'</td>';
            $html .= '<td>'.$r['masuk_L'].'</td>';
            $html .= '<td>'.$r['masuk_P'].'</td>';
            $html .= '<td>'.$r['keluar_L'].'</td>';
            $html .= '<td>'.$r['keluar_P'].'</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        $html .= '</body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="laporan_mutasi_penduduk_' . $start . '_' . $end . '.xls"',
        ]);
    }
}
