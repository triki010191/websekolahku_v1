@extends('layouts.admin')
@section('title', 'Pesan kontak')
@section('admin')
<h1 class="h4 mb-3">Pesan Hubungi Kami</h1>
<form method="get" class="row g-2 mb-3 small">
    <div class="col-auto">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Semua status</option>
            @foreach(['new'=>'Baru','read'=>'Dibaca','replied'=>'Ditanggapi'] as $k=>$l)
            <option value="{{ $k }}" @selected(request('status')===$k)>{{ $l }}</option>
            @endforeach
        </select>
    </div>
    <div class="col">
        <input class="form-control form-control-sm" name="q" value="{{ request('q') }}" placeholder="Cari nama, email, subjek">
    </div>
    <div class="col-auto"><button class="btn btn-sm btn-primary">Cari</button></div>
</form>
<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover mb-0 small">
        <thead class="table-light"><tr><th>Tanggal</th><th>Nama</th><th>Subjek</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($messages as $m)
            <tr>
                <td class="text-nowrap">{{ $m->created_at->translatedFormat('d M Y H:i') }}</td>
                <td>
                    <div class="fw-semibold">{{ $m->name }}</div>
                    <div class="text-muted" style="font-size:.75rem">{{ $m->email }}</div>
                </td>
                <td class="text-truncate" style="max-width:200px">{{ $m->subject }}</td>
                <td>
                    @if($m->status==='new')<span class="badge bg-primary">Baru</span>
                    @elseif($m->status==='read')<span class="badge bg-info text-dark">Dibaca</span>
                    @else<span class="badge bg-success">Ditanggapi</span>@endif
                </td>
                <td class="text-end text-nowrap">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.contact-messages.show', $m) }}">Buka</a>
                    <form class="d-inline" method="post" action="{{ route('admin.contact-messages.destroy', $m) }}" onsubmit="return confirm('Hapus?')">@csrf @method('delete')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-secondary py-4">Belum ada pesan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $messages->links() }}
@endsection
