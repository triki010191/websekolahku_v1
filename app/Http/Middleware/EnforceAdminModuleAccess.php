<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Batasi modul admin per role: super_admin = semua; admin_berita = hanya berita; admin_alumni = hanya data alumni.
 */
class EnforceAdminModuleAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return redirect()->route('admin.login');
        }

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        $name = $request->route()?->getName() ?? '';

        if ($name === 'admin.dashboard') {
            if ($user->hasRole(User::ROLE_ADMIN_BERITA)) {
                return redirect()->route('admin.posts.index');
            }
            if ($user->hasRole(User::ROLE_ADMIN_ALUMNI)) {
                return redirect()->route('admin.alumni-profiles.index');
            }
        }

        if ($user->hasRole(User::ROLE_ADMIN_BERITA)) {
            if (! str_starts_with($name, 'admin.posts.')) {
                abort(403, 'Akses hanya ke modul Berita & Artikel.');
            }

            return $next($request);
        }

        if ($user->hasRole(User::ROLE_ADMIN_ALUMNI)) {
            if (! str_starts_with($name, 'admin.alumni-profiles.')) {
                abort(403, 'Akses hanya ke modul Data Alumni.');
            }

            return $next($request);
        }

        return $next($request);
    }
}
