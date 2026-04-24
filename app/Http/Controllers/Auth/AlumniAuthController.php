<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AlumniProfile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumniAuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole(User::ROLE_ALUMNI)) {
                return redirect()->route('alumni.member.dashboard');
            }
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
        }

        return view('auth.alumni-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->isAdmin()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()
                    ->route('admin.login')
                    ->with('error', 'Akun admin silakan login melalui halaman Panel Admin.');
            }

            if (! $user->hasRole(User::ROLE_ALUMNI)) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors(['email' => 'Akses alumni hanya untuk akun dengan role alumni.'])
                    ->onlyInput('email');
            }

            return redirect()->intended(route('alumni.member.dashboard'));
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    public function dashboard()
    {
        $profile = AlumniProfile::where('user_id', auth()->id())->with('major')->first();

        return view('alumni.member', compact('profile'));
    }
}
