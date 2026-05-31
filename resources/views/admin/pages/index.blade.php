@extends('layouts.admin')
@section('title', 'Halaman')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="h4 mb-0">Halaman Konten</h1>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary btn-sm">+ Halaman Baru</a>
</div>
<p class="text-secondary small mb-3">Kelola halaman statis seperti Profil, SPMB, dan informasi sekolah lainnya.</p>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover small mb-0">
        <thead class="table-light">
            <tr>
                <th>Judul</th>
                <th>Slug / URL</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($pages as $p)
            <tr>
                <td class="fw-semibold">{{ $p->title }}</td>
                <td>
                    @if($p->slug === 'spmb-2026')
                        <code>/spmb-2026</code>
                    @else
                        <code>/profil/{{ $p->slug }}</code>
                    @endif
                </td>
                <td>
                    @if($p->is_published)
                        <span class="badge bg-success">Publik</span>
                    @else
                        <span class="badge bg-secondary">Draft</span>
                    @endif
                </td>
                <td class="text-end text-nowrap">
                    @if($p->slug === 'spmb-2026')
                        <a href="{{ route('spmb.index') }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat</a>
                    @else
                        <a href="{{ route('profil.show', $p->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary">Lihat</a>
                    @endif
                    <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.pages.destroy', $p) }}">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus halaman ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center text-secondary py-4">Belum ada halaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $pages->links() }}
@endsection
