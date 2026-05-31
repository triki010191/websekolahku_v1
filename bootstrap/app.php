<?php

use App\Http\Middleware\EnforceAdminModuleAccess;
use App\Http\Middleware\EnsureAlumniMember;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureTeacherMember;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware as MiddlewareConfig;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

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
            'teacher.member' => EnsureTeacherMember::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if (! $request->routeIs('ppdb.store', 'ppdb.draft')) {
                return null;
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesi formulir habis. Muat ulang halaman lalu coba lagi.',
                ], 419);
            }

            return redirect()->route('ppdb.create')
                ->with('error', 'Sesi formulir habis (Page Expired). Buka kembali halaman formulir — data draft Anda masih tersimpan di browser jika belum ditutup.');
        });

        $exceptions->render(function (TooManyRequestsHttpException $e, Request $request) {
            if (! $request->routeIs('ppdb.store', 'ppdb.draft')) {
                return null;
            }

            $retryAfter = $e->getHeaders()['Retry-After'] ?? 60;
            $message = "Terlalu banyak percobaan. Tunggu {$retryAfter} detik lalu coba lagi.";

            if ($request->expectsJson()) {
                return response()->json(['message' => $message], 429);
            }

            return redirect()->route('ppdb.create')
                ->with('error', $message);
        });
    })->create();
