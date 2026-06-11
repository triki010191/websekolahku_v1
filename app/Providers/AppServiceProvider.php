<?php

namespace App\Providers;

use App\Http\Controllers\SpmbController;
use App\Models\Major;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Proyek memakai Bootstrap, bukan Tailwind — default Laravel (SVG w-5 h-5) membesar tanpa Tailwind CSS.
        Paginator::useBootstrapFive();

        if (! $this->app->environment('testing')
            && ! $this->app->runningInConsole()
            && $this->app->has('request')) {
            $request = $this->app->make('request');
            if ($request->getHost() && in_array($request->getScheme() ?: 'http', ['http', 'https'], true)) {
                // XAMPP subfolder: asset() & route() harus pakai root URL sesuai browser, bukan APP_URL salah.
                $root = $request->root();
                // Sebelum middleware TrustProxies, skema sering "http" walau klien pakai https (ngrok, reverse proxy).
                // Tanpa ini, asset() jadi http di halaman https = mixed content, CSS/JS (hero-gradient, dsb) tidak ter-load.
                if ($request->header('X-Forwarded-Proto') === 'https' && str_starts_with($root, 'http://')) {
                    $root = 'https://'.substr($root, strlen('http://'));
                }
                URL::forceRootUrl($root);
            }
        }

        $this->ensureViewCompiledPathExists();
        $this->ensurePublicStorageLink();
        $this->registerMissingSpmbRoutes();

        Gate::policy(Post::class, PostPolicy::class);

        View::composer('partials.header', function ($view) {
            $view->with('navMajors', Major::orderBy('name')->get(['id', 'name', 'slug']));
        });
    }

    /**
     * Pastikan folder kompilasi Blade ada — mencegah error tempnam() (Blade) di Apache
     * bila proses web tidak bisa membuat subfolder.
     */
    private function ensureViewCompiledPathExists(): void
    {
        $path = config('view.compiled') ?: storage_path('framework/views');
        if (is_string($path) && $path !== '' && ! File::isDirectory($path)) {
            File::makeDirectory($path, 0755, true, true);
        }
    }

    /**
     * Membuat symlink public/storage jika belum ada (XAMPP / deploy baru sering lupa `php artisan storage:link`).
     */
    private function ensurePublicStorageLink(): void
    {
        if ($this->app->environment('testing')) {
            return;
        }
        $link = public_path('storage');
        $target = storage_path('app/public');
        if (File::exists($link) || ! File::isDirectory($target)) {
            return;
        }
        try {
            if (function_exists('symlink')) {
                symlink($target, $link);
            }
        } catch (\Throwable) {
            // Abaikan: Windows tanpa izin symlink, dll.
        }
    }

    /**
     * Cadangan jika route cache di hosting belum di-refresh setelah deploy
     * (sering terjadi bila artisan dijalankan di folder berbeda dari Laravel root).
     */
    private function registerMissingSpmbRoutes(): void
    {
        if ($this->app->runningInConsole()) {
            return;
        }

        $routes = [
            'spmb.tes-bakat-minat'  => ['uri' => '/spmb-2026/tes-bakat-minat', 'action' => 'tesBakatMinat'],
            'spmb.daftar-ulang'     => ['uri' => '/spmb-2026/daftar-ulang', 'action' => 'daftarUlang'],
            'spmb.panduan-dapodik'  => ['uri' => '/spmb-2026/panduan-dapodik', 'action' => 'panduanDapodik'],
        ];

        foreach ($routes as $name => $config) {
            if (Route::has($name)) {
                continue;
            }

            Route::get($config['uri'], [SpmbController::class, $config['action']])->name($name);
        }
    }
}
