<?php

use App\Http\Middleware\EnforceAdminModuleAccess;
use App\Http\Middleware\EnsureAlumniMember;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware as MiddlewareConfig;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (MiddlewareConfig $middleware): void {
        // Aplikasi memakai /admin/login (bukan Breeze default route('login'))
        $middleware->redirectGuestsTo(fn () => route('admin.login'));

        $proxies = env('TRUSTED_PROXIES');
        if ($proxies === '*') {
            $middleware->trustProxies(at: '*');
        } elseif (is_string($proxies) && $proxies !== '' && $proxies !== 'null') {
            $middleware->trustProxies(at: array_values(array_filter(array_map('trim', explode(',', $proxies)))));
        }

        $middleware->alias([
            'role' => RoleMiddleware::class,
            'admin' => EnsureIsAdmin::class,
            'admin.module' => EnforceAdminModuleAccess::class,
            'alumni.member' => EnsureAlumniMember::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
