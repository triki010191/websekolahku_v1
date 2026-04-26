@extends('layouts.admin')
@section('title', 'Fasilitas')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Fasilitas</h1>
    <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover mb-0 small">
        <thead class="table-light"><tr><th>Nama</th><th>Urutan</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @foreach($facilities as $f)
            <tr>
                <td>
                    <a href="{{ route('fasilitas.show', $f) }}" target="_blank" class="text-decoration-none">{{ $f->name }}</a>
                </td>
                <td>{{ $f->sort_order }}</td>
                <td>{!! $f->is_active ? '<span class="badge bg-success">Aktif</span>' : '<span class="badge bg-secondary">Off</span>' !!}</td>
                <td class="text-nowrap text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.facilities.edit', $f) }}">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.facilities.destroy', $f) }}" onsubmit="return confirm('Hapus?')">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $facilities->links() }}
@endsection
