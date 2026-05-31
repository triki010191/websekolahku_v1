<?php

use App\Models\Setting;

if (! function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return Setting::get($key, $default);
    }
}

/**
 * URL untuk file di disk public, atau URL absolut (http/https) untuk data lama / eksternal.
 */
if (! function_exists('public_storage_url')) {
    function public_storage_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }
        if (preg_match('#^https?://#i', $path) === 1) {
            return $path;
        }

        return asset('storage/'.ltrim($path, '/'));
    }
}

if (! function_exists('storage_file_exists')) {
    function storage_file_exists(?string $path): bool
    {
        if ($path === null || $path === '') {
            return false;
        }

        return is_file(storage_path('app/public/'.ltrim($path, '/')));
    }
}

if (! function_exists('public_asset_url')) {
    /** URL file statis di folder public/ jika ada di server. */
    function public_asset_url(string $path): ?string
    {
        $path = ltrim($path, '/');
        if (! is_file(public_path($path))) {
            return null;
        }

        return asset($path);
    }
}
