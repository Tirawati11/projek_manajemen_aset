<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckJabatan
{
    public function handle(Request $request, Closure $next, ...$jabatan)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        if (!in_array(Auth::user()->jabatan, $jabatan)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
