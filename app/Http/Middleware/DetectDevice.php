<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Jenssegers\Agent\Agent;

class DetectDevice
{
    public function handle(Request $request, Closure $next)
    {
        $agent = new Agent();
        $isMobile = $agent->isMobile() || $agent->isTablet();
        View::share('is_mobile', $isMobile);
        $request->attributes->set('is_mobile', $isMobile);
        return $next($request);
    }
}
