@extends('layouts.admin')
@section('title', 'Mitra kerjasama')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Mitra (DU-DI)</h1>
    <a href="{{ route('admin.partners.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover mb-0 small">
        <thead class="table-light"><tr><th>Nama</th><th>Industri</th><th>Urutan</th><th></th></tr></thead>
        <tbody>
            @foreach($partners as $p)
            <tr>
                <td>
                    <a href="{{ route('kerjasama.show', $p) }}" target="_blank" class="text-decoration-none fw-semibold">{{ $p->name }}</a>
                </td>
                <td>{{ $p->industry ?? '—' }}</td>
                <td>{{ $p->sort_order }}</td>
                <td class="text-nowrap text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.partners.edit', $p) }}">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.partners.destroy', $p) }}" onsubmit="return confirm('Hapus?')">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $partners->links() }}
@endsection
