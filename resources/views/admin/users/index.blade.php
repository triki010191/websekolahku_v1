@extends('layouts.admin')
@section('title', 'User')
@section('admin')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Pengguna</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">+ User</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light"><tr><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @foreach($users as $u)
            <tr>
                <td>{{ $u->name }}</td>
                <td>{{ $u->email }}</td>
                <td><span class="badge bg-dark">{{ $u->role }}</span></td>
                <td>{{ $u->status }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.users.edit', $u) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    @if($u->id !== auth()->id())
                    <form class="d-inline" method="post" action="{{ route('admin.users.destroy', $u) }}">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $users->links() }}
@endsection
