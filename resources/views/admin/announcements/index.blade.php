@extends('layouts.admin')
@section('title', 'Pengumuman')
@section('admin')
<div class="d-flex justify-content-between mb-3">
    <h1 class="h4">Pengumuman</h1>
    <a href="{{ route('admin.announcements.create') }}" class="btn btn-primary btn-sm">+ Baru</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light"><tr><th>Judul</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
            @foreach($announcements as $a)
            <tr>
                <td>{{ $a->title }}</td>
                <td><span class="badge bg-secondary">{{ $a->status }}</span></td>
                <td>{{ $a->published_at?->format('d M Y') }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.announcements.edit', $a) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.announcements.destroy', $a) }}">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $announcements->links() }}
@endsection
