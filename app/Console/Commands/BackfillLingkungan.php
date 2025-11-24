<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BiodataWarga;
use App\Models\DataKeluarga;

class BackfillLingkungan extends Command
{
    protected $signature = 'backfill:lingkungan {--batch=1000}';
    protected $description = 'Backfill lingkungan on biodata_warga from related data_keluarga using no_kk or family_id';

    public function handle()
    {
        $batch = (int) $this->option('batch');
        $this->info("Starting backfill (batch={$batch})...");

        $query = BiodataWarga::query();
        $total = $query->count();
        $this->info("Total residents: {$total}");

        BiodataWarga::chunk($batch, function($rows) {
            foreach ($rows as $r) {
                $ling = null;
                if ($r->family_id) {
                    $f = DataKeluarga::find($r->family_id);
                    if ($f) $ling = $f->lingkungan;
                }
                if (!$ling && $r->no_kk) {
                    $f = DataKeluarga::where('no_kk', $r->no_kk)->first();
                    if ($f) $ling = $f->lingkungan;
                }
                if ($ling && $r->lingkungan != $ling) {
                    $r->lingkungan = $ling;
                    $r->save();
                }
            }
        });

        $this->info('Backfill completed.');
        return 0;
    }
}
