@extends('layouts.app')
@section('title', 'Download — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Pusat Download</h1></div></section>
<section class="py-5"><div class="container">
    <form method="get" class="mb-4 row g-2">
        <div class="col-md-4">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">Semua kategori</option>
                @foreach($categories as $c)
                <option value="{{ $c->slug }}" @selected(request('category')===$c->slug)>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
    <div class="table-responsive shadow-sm rounded-3">
        <table class="table table-hover mb-0">
            <thead class="table-light"><tr><th>Judul</th><th>Kategori</th><th>Ukuran</th><th></th></tr></thead>
            <tbody>
                @forelse($downloads as $d)
                <tr>
                    <td>{{ $d->title }}</td>
                    <td>{{ $d->category?->name ?? '—' }}</td>
                    <td>{{ $d->size_human }}</td>
                    <td class="text-end"><a href="{{ route('download.file', $d) }}" class="btn btn-sm btn-primary">Download</a></td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-4">Tidak ada file.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $downloads->withQueryString()->links() }}</div>
</div></section>
@endsection
