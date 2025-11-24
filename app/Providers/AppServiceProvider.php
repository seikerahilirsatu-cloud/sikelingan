<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\PindahKeluar;
use App\Observers\PindahKeluarObserver;
use App\Models\DataKeluarga;
use App\Observers\DataKeluargaObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (config('app.env') === 'production') {
                URL::forceScheme('https');
            }
        } catch (\Throwable $e) {
        }
        // Register device-detection middleware alias and push to web group
        try {
            $router = $this->app->make(\Illuminate\Routing\Router::class);
            // alias and push to web group so views get `is_mobile` share
            $router->aliasMiddleware('detect.device', \App\Http\Middleware\DetectDevice::class);
            $router->aliasMiddleware('check.role', \App\Http\Middleware\CheckRole::class);
            $router->pushMiddlewareToGroup('web', \App\Http\Middleware\DetectDevice::class);
        } catch (\Throwable $e) {
            // If router isn't available (e.g., during certain artisan commands), skip
        }

        // Register model observers safely
        try {
            DataKeluarga::observe(DataKeluargaObserver::class);
            PindahKeluar::observe(PindahKeluarObserver::class);
        } catch (\Throwable $e) {
            // During certain artisan commands models may be unavailable; ignore
        }

        // Register audit observer for models that have audit fields
        try {
            $audit = \App\Observers\AuditObserver::class;
            DataKeluarga::observe($audit);
            \App\Models\BiodataWarga::observe($audit);
        } catch (\Throwable $e) {
            // ignore when models not available in artisan context
        }
    }
}
