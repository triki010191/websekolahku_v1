@extends('layouts.admin')
@section('title', 'Berita')
@section('admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Berita &amp; Artikel</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">+ Buat</a>
</div>
<form method="get" class="row g-2 mb-3">
    <div class="col-auto"><select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Status</option>
        <option value="draft" @selected(request('status')==='draft')>Draft</option>
        <option value="published" @selected(request('status')==='published')>Published</option>
    </select></div>
    <div class="col-auto"><select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
        <option value="">Kategori</option>
        @foreach($categories as $c)
        <option value="{{ $c->id }}" @selected(request('category')==$c->id)>{{ $c->name }}</option>
        @endforeach
    </select></div>
    <div class="col"><input class="form-control form-control-sm" name="search" value="{{ request('search') }}" placeholder="Cari..."></div>
    <div class="col-auto"><button class="btn btn-sm btn-outline-secondary">Cari</button></div>
</form>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover align-middle mb-0 small">
        <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Tanggal</th><th></th></tr></thead>
        <tbody>
            @foreach($posts as $p)
            <tr>
                <td>{{ $p->title }}</td>
                <td>{{ $p->category?->name ?? '—' }}</td>
                <td><span class="badge bg-secondary">{{ $p->status }}</span></td>
                <td>{{ $p->published_at?->format('d M Y') }}</td>
                <td class="text-end">
                    <a href="{{ route('admin.posts.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form action="{{ route('admin.posts.destroy', $p) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus?')">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $posts->withQueryString()->links() }}
@endsection
