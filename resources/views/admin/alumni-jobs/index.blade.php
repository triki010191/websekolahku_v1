@extends('layouts.admin')
@section('title', 'Lowongan')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Lowongan kerja (alumni)</h1>
    <a href="{{ route('admin.alumni-jobs.create') }}" class="btn btn-primary btn-sm">+ Tambah</a>
</div>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover mb-0 small">
        <thead class="table-light"><tr><th>Judul</th><th>Perusahaan</th><th>Status</th><th>Penutupan</th><th></th></tr></thead>
        <tbody>
            @foreach($jobs as $j)
            <tr>
                <td class="fw-semibold">{{ $j->title }}</td>
                <td>{{ $j->company }}</td>
                <td><span class="badge bg-secondary">{{ $j->status }}</span></td>
                <td>{{ $j->closes_at?->translatedFormat('d M Y') ?? '—' }}</td>
                <td class="text-nowrap text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.alumni-jobs.edit', $j) }}">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.alumni-jobs.destroy', $j) }}" onsubmit="return confirm('Hapus?')">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $jobs->links() }}
@endsection
