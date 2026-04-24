@extends('layouts.admin')
@section('title', 'Guru & TU')
@section('admin')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Guru &amp; TU</h1>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light"><tr><th>Nama</th><th>Posisi</th><th>Mapel / Bidang</th><th></th></tr></thead>
        <tbody>
            @foreach($teachers as $t)
            <tr>
                <td>{{ $t->name }}</td>
                <td>{{ $t->position }}</td>
                <td>{{ $t->subject ?? $t->field }}</td>
                <td class="text-end">
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
