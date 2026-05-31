<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.form', ['user' => new User()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'role'     => ['required', 'in:super_admin,admin_berita,admin_alumni,alumni,guru'],
            'phone'    => ['nullable', 'string', 'max:32'],
            'status'   => ['required', 'in:active,pending,suspended'],
            'password' => ['required', Password::min(6)],
        ]);

        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna dibuat.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'role'     => ['required', 'in:super_admin,admin_berita,admin_alumni,alumni,guru'],
            'phone'    => ['nullable', 'string', 'max:32'],
            'status'   => ['required', 'in:active,pending,suspended'],
            'password' => ['nullable', Password::min(6)],
        ]);

        if (empty($data['password'])) unset($data['password']);
        else $data['password'] = Hash::make($data['password']);

        $user->update($data);
        return redirect()->route('admin.users.index')->with('success', 'Pengguna diperbarui.');
    }

    public function destroy(Request $request, User $user)
    {
        abort_if($user->id === $request->user()->id, 403, 'Tidak bisa menghapus akun sendiri.');
        $user->delete();
        return back()->with('success', 'Pengguna dihapus.');
    }
}
