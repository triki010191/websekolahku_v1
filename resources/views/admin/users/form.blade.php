@extends('layouts.admin')
@section('title', 'User')
@section('admin')
<h1 class="h4 mb-3">{{ $user->exists ? 'Edit' : 'Tambah' }} User</h1>
<form method="post" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}" class="card border-0 shadow-sm p-4" style="max-width:500px">
    @csrf
    @if($user->exists) @method('put') @endif
    <div class="mb-2"><label class="form-label">Nama *</label><input class="form-control" name="name" value="{{ old('name', $user->name) }}" required></div>
    <div class="mb-2"><label class="form-label">Email *</label><input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required></div>
    <div class="mb-2">
        <label class="form-label">Role *</label>
        <select name="role" class="form-select" required>
            <option value="super_admin" @selected(old('role', $user->role)==='super_admin')>Super Admin</option>
            <option value="admin_berita" @selected(old('role', $user->role)==='admin_berita')>Admin Berita</option>
            <option value="admin_alumni" @selected(old('role', $user->role)==='admin_alumni')>Admin Alumni</option>
            <option value="alumni" @selected(old('role', $user->role)==='alumni')>Alumni</option>
            <option value="guru" @selected(old('role', $user->role)==='guru')>Guru / TU</option>
        </select>
    </div>
    <div class="mb-2">
        <label class="form-label">Status *</label>
        <select name="status" class="form-select" required>
            @foreach(['active','pending','suspended'] as $s)
            <option value="{{ $s }}" @selected(old('status', $user->status ?? 'active')===$s)>{{ $s }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-2"><label class="form-label">Password {{ $user->exists ? '(kosong = tidak diubah)' : '*' }}</label><input type="password" name="password" class="form-control" {{ $user->exists ? '' : 'required' }}></div>
    <button class="btn btn-primary">Simpan</button>
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
</form>
@endsection
