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
        $override = $request->query('m');
        if ($override === '1') {
            $isMobile = true;
        } elseif ($override === '0') {
            $isMobile = false;
        } else {
            $isMobile = $agent->isMobile();
        }
        View::share('is_mobile', $isMobile);
        $request->attributes->set('is_mobile', $isMobile);
        return $next($request);
    }
}
