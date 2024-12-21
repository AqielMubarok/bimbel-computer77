<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Periksa apakah pengguna adalah ADMIN atau PEMATERI
        if (auth()->check() && in_array(auth()->user()->rul, ['ADMIN', 'PEMATERI'])) {
            return $next($request);
        }

        // Jika tidak, arahkan ke halaman home dengan pesan error
        return redirect()->route('home')->with('error', 'Akses hanya untuk Admin atau Pemateri.');
    }
}