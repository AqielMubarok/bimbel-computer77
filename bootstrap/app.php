<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use App\Http\Middleware\Admin;
use App\Http\Middleware\CheckPaymentStatus;
use App\Http\Middleware\Pemateri;
use App\Http\Middleware\Peserta;
use App\Http\Middleware\CheckAccess;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //auth admin pemateri peserta class 
        $middleware->alias([
            'admin'=> Admin::class, 
            'pemateri'=> Pemateri::class,
            'peserta'=> Peserta::class,
            'checkAccess' => CheckAccess::class,
            'checkPaymentStatus' => CheckPaymentStatus::class,

        ]);
 
        
    })

   
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
