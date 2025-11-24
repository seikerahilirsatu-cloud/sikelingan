<?php

namespace App\Observers;

use App\Models\PindahKeluar;
use Illuminate\Support\Facades\DB;

class PindahKeluarObserver
{
    /**
     * Handle the PindahKeluar "created" event.
     *
     * @param  \App\Models\PindahKeluar  $pindah
     * @return void
     */
    public function created(PindahKeluar $pindah)
    {
        // When a move-out is recorded, mark the resident as 'pindah' and store tanggal_pindah if column exists.
        DB::transaction(function () use ($pindah) {
            $warga = $pindah->warga;
            if (! $warga) {
                return;
            }

            // update flag_status (preferred) or status_warga if present
            if (array_key_exists('flag_status', $warga->getAttributes())) {
                $warga->flag_status = 'pindah';
            } elseif (array_key_exists('status_warga', $warga->getAttributes())) {
                $warga->status_warga = 'pindah';
            }

            if (array_key_exists('tanggal_pindah', $warga->getAttributes())) {
                $warga->tanggal_pindah = $pindah->tanggal_pindah;
            }

            // Optionally store last_pindah_id if column exists
            if (array_key_exists('current_pindah_id', $warga->getAttributes())) {
                $warga->current_pindah_id = $pindah->id;
            }

            $warga->save();
        });
    }
}
