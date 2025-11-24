<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Backfill lingkungan on biodata_warga from related data_keluarga
Artisan::command('backfill:lingkungan {--batch=1000}', function () {
    $batch = (int) $this->option('batch');
    $this->info("Starting backfill (batch={$batch})...");

    $total = \App\Models\BiodataWarga::count();
    $this->info("Total residents: {$total}");

    \App\Models\BiodataWarga::chunk($batch, function($rows) {
        foreach ($rows as $r) {
            $ling = null;
            if ($r->family_id) {
                $f = \App\Models\DataKeluarga::find($r->family_id);
                if ($f) $ling = $f->lingkungan;
            }
            if (!$ling && $r->no_kk) {
                $f = \App\Models\DataKeluarga::where('no_kk', $r->no_kk)->first();
                if ($f) $ling = $f->lingkungan;
            }
            if ($ling && $r->lingkungan != $ling) {
                $r->lingkungan = $ling;
                $r->save();
            }
        }
    });

    $this->info('Backfill completed.');
})->describe('Backfill lingkungan on biodata_warga from related data_keluarga');
