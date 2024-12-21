<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Pemateri
{
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan pengguna memiliki peran PEMATERI
        if (auth()->check() && auth()->user()->rul === 'PEMATERI') {
            return $next($request);
        }

        // Jika bukan PEMATERI, arahkan ke halaman home dengan pesan error
        return redirect()->route('home')->with('error', 'Akses hanya untuk Pemateri.');
    }
}
