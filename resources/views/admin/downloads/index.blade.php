@extends('layouts.admin')
@section('title', 'File download')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">File unduhan</h1>
    <a href="{{ route('admin.downloads.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover mb-0 small">
        <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Ukuran</th><th>Unduhan</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($downloads as $d)
            <tr>
                <td class="fw-semibold">{{ $d->title }}</td>
                <td>{{ $d->category?->name ?? '—' }}</td>
                <td>{{ $d->size_human }}</td>
                <td>{{ $d->download_count }}</td>
                <td>{!! $d->is_public ? '<span class="badge bg-success">Publik</span>' : '<span class="badge bg-secondary">Rahasia</span>' !!}</td>
                <td class="text-nowrap text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.downloads.edit', $d) }}">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.downloads.destroy', $d) }}" onsubmit="return confirm('Hapus?')">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-secondary py-4">Belum ada file.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $downloads->links() }}
@endsection
