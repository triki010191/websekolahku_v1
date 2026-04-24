@extends('layouts.admin')
@section('title', 'Jurusan')
@section('admin')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Jurusan</h1>
    <a href="{{ route('admin.majors.create') }}" class="btn btn-primary btn-sm">+ Baru</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light"><tr><th>Kode</th><th>Nama</th><th>Aktif</th><th></th></tr></thead>
        <tbody>
            @foreach($majors as $m)
            <tr>
                <td>{{ $m->code }}</td>
                <td>{{ $m->name }}</td>
                <td>{{ $m->is_active ? 'Ya' : 'Tidak' }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.majors.edit', $m) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.majors.destroy', $m) }}">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
