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
