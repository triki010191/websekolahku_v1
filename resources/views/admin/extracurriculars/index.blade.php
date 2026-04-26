@extends('layouts.admin')
@section('title', 'Ekstrakurikuler')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Ekstrakurikuler</h1>
    <a href="{{ route('admin.extracurriculars.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover mb-0 small">
        <thead class="table-light"><tr><th>Nama</th><th></th><th>Urutan</th><th></th></tr></thead>
        <tbody>
            @foreach($extracurriculars as $e)
            <tr>
                <td><a href="{{ route('ekstrakurikuler.show', $e) }}" target="_blank" class="text-decoration-none fw-semibold">{{ $e->name }}</a></td>
                <td><span class="text-muted">{{ $e->category }}</span></td>
                <td>{{ $e->sort_order }}</td>
                <td class="text-nowrap text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.extracurriculars.edit', $e) }}">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.extracurriculars.destroy', $e) }}" onsubmit="return confirm('Hapus?')">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $extracurriculars->links() }}
@endsection
