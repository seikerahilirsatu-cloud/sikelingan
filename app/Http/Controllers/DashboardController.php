<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $isMobile = (bool) $request->attributes->get('is_mobile', true);
        if ($isMobile) {
            return view('home');
        }
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('dashboard');
    }
}
