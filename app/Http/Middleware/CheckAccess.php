<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAccess
{
    /**
     * Definisi aturan akses untuk setiap role dan route
     */
    protected $accessRules = [
        'ADMIN' => [
            'user*',              // Hanya admin yang bisa akses management user
            'lecturer',
            'lecturer/create',
            'lecturer/*/edit',
            'tugas',
            'tugas/create',
            'kumpul/index',
            'kumpul/create',      // Hanya admin yang bisa akses ini
            'nilai',
            'nilai/*/create',
            'nilai/*/edit',
            'lihatnilai',
            'pembayaran',         // Hanya admin yang bisa akses management pembayaran
            'pembayaran/*/edit',
            'Pembayaran/export'
        ],
        'PESERTA' => [
            'pembayaran/history',
            'paket',
            'form.bayar',
            'lecturer',
            'tugas',
            'lihatnilai',
            'kumpul/create'       // Peserta bisa mengumpulkan tugas
        ],
        'PEMATERI' => [
            'lecturer',
            'lecturer/create',
            'lecturer/*/edit',
            'tugas',
            'tugas/create',
            'nilai',
            'nilai/*/create',
            'nilai/*/edit',
            'lihatnilai'
        ]
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $currentPath = $request->path();

        // Jika user tidak memiliki role yang valid
        if (!isset($this->accessRules[$user->rul])) {
            return redirect()
                ->route('home')
                ->with('error', 'Role tidak valid.');
        }

        // Cek apakah current path diizinkan untuk role user
        $hasAccess = false;
        foreach ($this->accessRules[$user->rul] as $allowedPath) {
            // Menggunakan wildcard matching
            if (fnmatch($allowedPath, $currentPath)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            // Redirect berdasarkan role
            if ($user->rul === 'PESERTA') {
                return redirect()
                    ->route('dashboard_lms')
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            } else {
                return redirect()
                    ->route('dashboard')
                    ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }

        return $next($request);
    }
}