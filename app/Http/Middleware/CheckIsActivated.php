<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CheckIsActivated
{
    public function handle($request, Closure $next)
{
    if (Auth::check() && Auth::user()->jabatan == 'admin') {
        return $next($request);
    }

    if (!Auth::user()->is_activated) {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Akun anda belum diaktifkan.');
    }

    return $next($request);
}
}
