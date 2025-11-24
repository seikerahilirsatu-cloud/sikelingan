<?php

namespace App\Observers;

use App\Models\DataKeluarga;
use App\Models\BiodataWarga;
use Illuminate\Support\Facades\DB;

class DataKeluargaObserver
{
    /**
     * Handle the DataKeluarga "updated" event.
     */
    public function updated(DataKeluarga $family): void
    {
        // If no_kk changed, sync to residents that reference this family_id
        if ($family->wasChanged('no_kk')) {
            DB::transaction(function () use ($family) {
                BiodataWarga::where('family_id', $family->id)
                    ->update(['no_kk' => $family->no_kk]);
            });
        }
        // If lingkungan changed, sync denormalized lingkungan on residents
        if ($family->wasChanged('lingkungan')) {
            DB::transaction(function () use ($family) {
                BiodataWarga::where('family_id', $family->id)
                    ->update(['lingkungan' => $family->lingkungan]);
            });
        }
    }
}
