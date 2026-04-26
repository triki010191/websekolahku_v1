<?php

namespace App\Providers;

use App\Models\Major;
use App\Models\Post;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;
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
}
