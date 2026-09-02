<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah ada parameter 'lang' di URL
        if ($request->has('lang')) {
            $lang = $request->input('lang');
            
            // Validasi bahasa yang diizinkan (hanya 'id' atau 'en')
            if (in_array($lang, ['id', 'en'])) {
                session(['locale' => $lang]);
            }
        }

        // Jika session belum ada, set default 'id'
        if (!session()->has('locale')) {
            session(['locale' => 'id']);
        }

        // Set locale untuk aplikasi
        app()->setLocale(session('locale'));

        return $next($request);
    }
}