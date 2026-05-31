@extends('layouts.admin')
@section('title', 'Guru & TU')
@section('admin')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <h1 class="h4 mb-0">Guru &amp; TU</h1>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.teachers.export.template') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-spreadsheet"></i> Template Import</a>
        <a href="{{ route('admin.teachers.export.excel') }}" class="btn btn-outline-success btn-sm"><i class="bi bi-download"></i> Export Excel</a>
        <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 mb-3" style="max-width:520px">
    <form method="post" action="{{ route('admin.teachers.import.excel') }}" enctype="multipart/form-data" class="d-flex flex-wrap gap-2 align-items-end">
        @csrf
        <div class="flex-grow-1">
            <label class="form-label small mb-1">Import dari Excel</label>
            <input type="file" name="file" class="form-control form-control-sm" accept=".xlsx,.xls,.csv" required>
        </div>
        <button class="btn btn-sm btn-primary">Import</button>
    </form>
    <p class="small text-secondary mb-0 mt-2">Unduh template, isi data, lalu import. Baris dengan NIP/ID sama akan diperbarui.</p>
</div>

<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light"><tr><th>Nama</th><th>Posisi</th><th>Mapel / Bidang</th><th>Akun</th><th></th></tr></thead>
        <tbody>
            @foreach($teachers as $t)
            <tr>
                <td>{{ $t->name }}</td>
                <td>{{ $t->position }}</td>
                <td>{{ $t->subject ?? $t->field }}</td>
                <td>
                    @if($t->user)
                    <span class="badge text-bg-success">Login</span>
                    @else
                    <span class="badge text-bg-secondary">Belum</span>
                    @endif
                </td>
                <td class="text-end">
                    @if($t->slug)
                    <a href="{{ route('guru.show', $t) }}" class="btn btn-sm btn-outline-secondary" target="_blank" title="Lihat profil">Profil</a>
                    @endif
                    <a href="{{ route('admin.teachers.edit', $t) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.teachers.destroy', $t) }}">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $teachers->links() }}
@endsection
