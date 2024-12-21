<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentStatus
{
    protected $requiresApprovedPayment = [
        'lecturer',
        'tugas',
        'lihatnilai',
        'kumpul/create',
        'pembayaran/history'
    ];

    protected $preApprovalRoutes = [
        'paket',
        'form.bayar',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Bypass pengecekan untuk admin dan pemateri
        if (in_array($user->rul, ['ADMIN', 'PEMATERI'])) {
            return $next($request);
        }

        // Handle PESERTA access
        if ($user->rul === 'PESERTA') {
            $pembayaran = $user->pembayaran()->latest()->first();
            $currentPath = $request->path();

            // Check if payment exists and is approved
            $isPaymentApproved = $pembayaran && $pembayaran->status === 'Approved';

            // Block access to pre-approval routes if payment is approved
            if ($isPaymentApproved) {
                foreach ($this->preApprovalRoutes as $route) {
                    if ($request->is($route)) {
                        return redirect()
                            ->route('dashboard_lms')
                            ->with('error', 'Anda sudah melakukan pembayaran dan tidak dapat mengakses halaman ini.');
                    }
                }
            }

            // Block access to protected routes if payment is not approved
            if (!$isPaymentApproved) {
                foreach ($this->requiresApprovedPayment as $route) {
                    if ($request->is($route)) {
                        return redirect()
                            ->route('pages.Pembayaran.paket')  // Menggunakan nama route yang benar
                            ->with('error', 'Anda harus menyelesaikan pembayaran untuk mengakses halaman ini.');
                    }
                }
            }

            return $next($request);
        }

        // If role is not recognized
        return redirect()
            ->route('home')
            ->with('error', 'Akses tidak sah.');
    }
}