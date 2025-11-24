<?php

namespace App\Observers;

use Illuminate\Support\Facades\Auth;

class AuditObserver
{
    public function creating($model)
    {
        try {
            $userId = Auth::id();
            if ($userId) {
                if (property_exists($model, 'created_by')) {
                    $model->created_by = $userId;
                }
                if (property_exists($model, 'updated_by')) {
                    $model->updated_by = $userId;
                }
            }
        } catch (\Throwable $e) {
            // ignore when running in console without auth
        }
    }

    public function updating($model)
    {
        try {
            $userId = Auth::id();
            if ($userId && property_exists($model, 'updated_by')) {
                $model->updated_by = $userId;
            }
        } catch (\Throwable $e) {
            // ignore
        }
    }
}
