@extends('layouts.admin')
@section('title', 'Slider Beranda')
@section('admin')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h4 mb-0">Slider beranda</h1>
    <a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Slide baru</a>
</div>
<p class="text-secondary small mb-3">Tampil di atas hero jika ada slide aktif. Gambar dipotong otomatis menyesuaikan layar.</p>
<div class="table-responsive shadow-sm rounded-3 bg-body">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light"><tr>
            <th style="width:100px">Gambar</th>
            <th>Judul</th>
            <th>Urutan</th>
            <th>Status</th>
            <th></th>
        </tr></thead>
        <tbody>
            @forelse($slides as $s)
            <tr>
                <td>
                    @if($s->image)
                        <img src="{{ asset('storage/'.$s->image) }}" alt="" class="rounded border" style="width:88px;height:52px;object-fit:cover">
                    @endif
                </td>
                <td>
                    <div class="fw-semibold">{{ $s->title }}</div>
                    @if($s->subtitle)<div class="small text-secondary text-truncate" style="max-width:280px">{{ $s->subtitle }}</div>@endif
                </td>
                <td>{{ $s->sort_order }}</td>
                <td>
                    @if($s->is_active)<span class="badge bg-success">Aktif</span>
                    @else<span class="badge bg-secondary">Nonaktif</span>@endif
                </td>
                <td class="text-end">
                    <a href="{{ route('admin.hero-slides.edit', $s) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.hero-slides.destroy', $s) }}" onsubmit="return confirm('Hapus slide?')">@csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada slide. Klik <strong>Slide baru</strong> untuk menambah.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $slides->links() }}
@endsection
