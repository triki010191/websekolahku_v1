<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAlumniMember
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('alumni.login');
        }

        if (! $request->user()->hasRole(User::ROLE_ALUMNI)) {
            abort(403, 'Halaman ini hanya untuk akun alumni.');
        }

        return $next($request);
    }
}
