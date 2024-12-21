<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Peserta
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna sudah login
        if (auth()->check()) {
            $user = $request->user();

            // Periksa apakah pengguna memiliki peran PESERTA
            if ($user->rul === 'PESERTA') {
                // Lanjutkan request jika pengguna adalah PESERTA
                return $next($request);
            }
        }

        // Redirect jika bukan PESERTA
        return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
