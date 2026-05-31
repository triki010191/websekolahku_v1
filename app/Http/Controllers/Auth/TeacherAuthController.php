<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class TeacherAuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            if (auth()->user()->hasRole(User::ROLE_GURU)) {
                return redirect()->route('guru.member.dashboard');
            }
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->hasRole(User::ROLE_ALUMNI)) {
                return redirect()->route('alumni.member.dashboard');
            }
        }

        return view('auth.teacher-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'Email atau password salah.'])
                ->onlyInput('email');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->isAdmin()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('admin.login')
                ->with('error', 'Akun admin silakan login melalui Panel Admin.');
        }

        if ($user->hasRole(User::ROLE_ALUMNI)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('alumni.login')
                ->with('error', 'Akun alumni silakan login melalui Area Alumni.');
        }

        if (! $user->hasRole(User::ROLE_GURU)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Akses hanya untuk akun Guru & TU.'])
                ->onlyInput('email');
        }

        if ($user->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withErrors(['email' => 'Akun belum aktif. Hubungi administrator.'])
                ->onlyInput('email');
        }

        return redirect()->intended(route('guru.member.dashboard'));
    }

    public function dashboard()
    {
        $teacher = Teacher::where('user_id', auth()->id())->first();

        return view('guru.member', compact('teacher'));
    }

    public function updateProfile(Request $request)
    {
        $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();

        $data = $request->validate([
            'nip'       => ['nullable', 'string', 'max:30'],
            'name'      => ['required', 'string', 'max:255'],
            'position'  => ['required', 'string', 'max:255'],
            'subject'   => ['nullable', 'string', 'max:255'],
            'education' => ['nullable', 'string', 'max:255'],
            'email'     => ['nullable', 'email', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:32'],
            'motto'     => ['nullable', 'string', 'max:500'],
            'bio'       => ['nullable', 'string'],
            'photo'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);

        if ($teacher->name !== $data['name']) {
            $data['slug'] = $this->makeSlug($data['name'], $teacher->id);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $this->storePhoto($request);
        }

        $teacher->update($data);

        if ($teacher->user && filled($data['email'])) {
            $teacher->user->update(['email' => $data['email'], 'name' => $data['name']]);
        }

        $message = $request->hasFile('photo')
            ? 'Profil dan foto berhasil diperbarui.'
            : 'Profil berhasil diperbarui.';

        return back()->with('success', $message);
    }

    private function storePhoto(Request $request): string
    {
        $dir = storage_path('app/public/teachers');
        if (! is_dir($dir) && ! mkdir($dir, 0775, true) && ! is_dir($dir)) {
            throw ValidationException::withMessages([
                'photo' => 'Folder upload tidak bisa dibuat. Hubungi administrator server.',
            ]);
        }
        if (! is_writable($dir)) {
            throw ValidationException::withMessages([
                'photo' => 'Folder storage/teachers tidak bisa ditulis. Minta admin jalankan: chmod -R 775 storage/app/public',
            ]);
        }

        try {
            $path = $request->file('photo')->store('teachers', 'public');
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'photo' => 'Gagal menyimpan foto: '.$e->getMessage(),
            ]);
        }

        if (! Storage::disk('public')->exists($path)) {
            throw ValidationException::withMessages([
                'photo' => 'Foto gagal disimpan ke server.',
            ]);
        }

        return $path;
    }

    private function makeSlug(string $name, int $exceptId): string
    {
        $base = Str::slug($name) ?: 'guru';
        $slug = $base;
        $i = 1;
        while (Teacher::where('slug', $slug)->where('id', '!=', $exceptId)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
