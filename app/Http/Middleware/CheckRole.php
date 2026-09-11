<?php

/* =========================================================
    NAMESPACE & IMPORT
========================================================= */
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/* =========================================================
    MIDDLEWARE: CHECK ROLE
========================================================= */
class CheckRole
{
    /* =========================================================
        HANDLE REQUEST & VALIDASI ROLE
    ========================================================= */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        return redirect('/admin')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}