<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Models\DataKeluarga;
use App\Models\BiodataWarga;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ImportController extends Controller
{
    public function biodataTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_biodata_warga.csv"',
        ];
        $columns = ['no_kk','nik','nama_lgkp','jenis_kelamin','tgl_lhr','agama','pendidikan_terakhir','pekerjaan','stts_kawin','stts_hub_keluarga'];
        return response()->stream(function () use ($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fclose($out);
        }, 200, $headers);
    }

    public function familyForm()
    {
        return view('import.keluarga_form');
    }

    public function familyPreview(Request $request)
    {
        $request->validate(['csv' => 'required|file|mimes:csv,txt']);
        $path = $request->file('csv')->getRealPath();
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $headers = null;
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                if (!$headers) { $headers = array_map(fn($h)=>trim($h), $data); continue; }
                $row = [];
                foreach ($headers as $i=>$h) { $row[$h] = $data[$i] ?? null; }
                $rows[] = $row;
            }
            fclose($handle);
        }

        $items = [];
        foreach ($rows as $r) {
            $no_kk = trim($r['no_kk'] ?? '');
            $nama_kep = trim(($r['nama_kep'] ?? '') ?: ($r['nama'] ?? ''));
            $alamat = trim($r['alamat'] ?? '');
            $lingkungan = trim($r['lingkungan'] ?? '');
            $status_keluarga = isset($r['status_keluarga']) ? (int) $r['status_keluarga'] : null;
            $errors = [];
            if (!$no_kk) $errors[] = 'Missing no_kk';
            if (!$nama_kep) $errors[] = 'Missing nama_kep';
            if (!$alamat) $errors[] = 'Missing alamat';
            $existing = $no_kk ? \App\Models\DataKeluarga::where('no_kk',$no_kk)->first() : null;
            $items[] = [
                'action' => $existing ? 'update' : 'insert',
                'data' => compact('no_kk','nama_kep','alamat','lingkungan','status_keluarga'),
                'errors' => $errors,
                'skip' => count($errors) > 0,
            ];
        }

        return view('import.keluarga_preview', compact('items'));
    }

    public function familyCommit(Request $request)
    {
        $items = $request->input('items', []);
        $created = 0; $updated = 0; $skipped = 0;
        DB::transaction(function () use (&$created,&$updated,&$skipped,$items) {
            foreach ($items as $it) {
                $data = $it['data'] ?? [];
                $no_kk = $data['no_kk'] ?? null;
                $nama_kep = $data['nama_kep'] ?? null;
                $alamat = $data['alamat'] ?? null;
                if (!$no_kk || !$nama_kep || !$alamat) { $skipped++; continue; }
                $payload = [
                    'nama_kep' => $nama_kep,
                    'alamat' => $alamat,
                    'lingkungan' => $data['lingkungan'] ?? null,
                    'status_keluarga' => $data['status_keluarga'] ?? 1,
                ];
                $model = \App\Models\DataKeluarga::where('no_kk', $no_kk)->first();
                if ($model) { $model->update($payload); $updated++; }
                else {
                    $payload['no_kk'] = $no_kk;
                    if (Auth::id()) { $payload['created_by'] = Auth::id(); $payload['updated_by'] = Auth::id(); }
                    \App\Models\DataKeluarga::create($payload); $created++;
                }
            }
        });
        return redirect()->route('data_keluarga.index')->with('success', "Import keluarga selesai. Created: $created, Updated: $updated, Skipped: $skipped");
    }

    public function familyTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_data_keluarga.csv"',
        ];
        $columns = ['no_kk','nama_kep','alamat','lingkungan','status_keluarga'];
        return response()->stream(function () use ($columns) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $columns);
            fclose($out);
        }, 200, $headers);
    }
    public function form()
    {
        return view('import.form');
    }

    public function biodataForm()
    {
        return view('import.biodata_form');
    }

    public function preview(Request $request)
    {
        $request->validate([ 'csv' => 'required|file|mimes:csv,txt' ]);
        $path = $request->file('csv')->getRealPath();
        $rows = [];
        if (($handle = fopen($path, 'r')) !== false) {
            $headers = null;
            while (($data = fgetcsv($handle, 0, ',')) !== false) {
                if (! $headers) {
                    $headers = array_map(fn($h)=>trim($h), $data);
                    continue;
                }
                $row = [];
                foreach ($headers as $i=>$h) {
                    $row[$h] = $data[$i] ?? null;
                }
                $rows[] = $row;
            }
            fclose($handle);
        }

        // classify rows and validate
        $preview = [];
        $seenNiks = [];
        $errors = [];
        foreach ($rows as $index => $r) {
            $nik = trim($r['nik'] ?? '');
            $no_kk = trim($r['no_kk'] ?? '');
            $rowErrors = [];

            if (empty($nik)) {
                $rowErrors[] = 'Missing NIK';
            } else {
                if (!preg_match('/^\d{9,20}$/', $nik)) {
                    $rowErrors[] = 'NIK looks invalid';
                }
            }

            if ($nik) {
                if (in_array($nik, $seenNiks)) {
                    $rowErrors[] = 'Duplicate NIK in file';
                }
                $seenNiks[] = $nik;
            }

            $existing = $nik ? BiodataWarga::where('nik',$nik)->first(): null;
            $status = $existing ? 'update' : 'insert';

            $preview[] = [
                'row' => $r,
                'status' => $status,
                'errors' => $rowErrors,
                'skip' => count($rowErrors) > 0
            ];

            if (count($rowErrors)) {
                $errors[$index] = $rowErrors;
            }
        }

        Session::put('import_preview', ['rows' => $preview, 'filename' => $request->file('csv')->getClientOriginalName()]);
        return view('import.preview', ['preview' => $preview, 'errors' => $errors]);
    }

    public function commit(Request $request)
    {
        $previewData = Session::get('import_preview', ['rows' => []]);
        $preview = $previewData['rows'] ?? [];
        $filename = $previewData['filename'] ?? null;

        $created = 0; $updated = 0; $skipped = 0; $errors = [];

        $selected = $request->input('do', []);

        DB::transaction(function() use(&$created,&$updated,&$skipped,&$errors,$preview,&$filename,$selected) {
            foreach ($preview as $idx => $p) {
                // only process if user checked this row in preview
                if (! array_key_exists($idx, $selected)) { $skipped++; continue; }
                if (! empty($p['skip'])) { $skipped++; continue; }
                $r = $p['row'];
                $nik = trim($r['nik'] ?? '');
                $no_kk = trim($r['no_kk'] ?? '');
                if (! $nik) { $skipped++; continue; }

                try {
                    $family = null;
                    if ($no_kk) {
                        $family = DataKeluarga::firstOrCreate(
                            ['no_kk' => $no_kk],
                            ['nama_kep' => $r['nama_kep'] ?? ($r['nama_lgkp'] ?? 'Unknown'), 'alamat' => $r['alamat'] ?? '', 'status_keluarga'=>1]
                        );
                    }

                    $existing = BiodataWarga::where('nik',$nik)->first();
                    $data = [
                        'family_id' => $family? $family->id : null,
                        'no_kk' => $family? $family->no_kk : ($no_kk ?: null),
                        'nik' => $nik,
                        'nama_lgkp' => $r['nama_lgkp'] ?? $r['nama'] ?? null,
                        'jenis_kelamin' => $r['jenis_kelamin'] ?? null,
                        'tgl_lhr' => $r['tgl_lhr'] ?? null,
                        'agama' => $r['agama'] ?? null,
                        'pendidikan_terakhir' => $r['pendidikan_terakhir'] ?? null,
                        'pekerjaan' => $r['pekerjaan'] ?? null,
                        'stts_kawin' => $r['stts_kawin'] ?? null,
                        'stts_hub_keluarga' => $r['stts_hub_keluarga'] ?? null,
                        'status_warga' => $family? $family->status_keluarga : null,
                        'flag_status' => 'Aktif'
                    ];

                    if ($existing) {
                        // set updated_by if available
                        if (Auth::id()) {
                            $data['updated_by'] = Auth::id();
                        }
                        $existing->update($data);
                        $updated++;
                    } else {
                        // set created_by and updated_by when creating
                        if (Auth::id()) {
                            $data['created_by'] = Auth::id();
                            $data['updated_by'] = Auth::id();
                        }
                        BiodataWarga::create($data);
                        $created++;
                    }
                } catch (\Throwable $e) {
                    $errors[$idx] = $e->getMessage();
                }
            }
        });

        try {
            DB::table('import_jobs')->insert([
                'filename' => $filename,
                'user_id' => Auth::id(),
                'summary' => json_encode(['created'=>$created,'updated'=>$updated,'skipped'=>$skipped]),
                'errors' => json_encode($errors),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging failures
        }

        Session::forget('import_preview');
        return redirect()->route('biodata_warga.index')->with('success', "Import selesai. Created: $created, Updated: $updated, Skipped: $skipped");
    }
}
