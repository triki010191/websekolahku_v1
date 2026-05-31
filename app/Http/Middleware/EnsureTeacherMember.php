<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeacherMember
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->route('guru.login');
        }

        if (! $request->user()->hasRole(User::ROLE_GURU)) {
            abort(403, 'Halaman ini hanya untuk akun Guru & TU.');
        }

        return $next($request);
    }
}
