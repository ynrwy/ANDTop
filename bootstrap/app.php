<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo('/');
        $middleware->redirectUsersTo(function () {
            session()->flash('success', 'Anda sudah masuk. Untuk mengganti password, gunakan menu Profil lalu pilih Ubah Password.');
            return '/dashboard';
        });
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);

        // Cek status akun di setiap request
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureUserIsActive::class);

        //Payment Gateway
        $middleware->validateCsrfTokens(except: ['payment/notification']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
