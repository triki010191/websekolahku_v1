@extends('layouts.admin')
@section('title', 'Pesan kontak')
@section('admin')
<div class="mb-3">
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-sm btn-outline-secondary">← Kembali</a>
</div>
<div class="card border-0 shadow-sm p-4" style="max-width:800px">
    <div class="d-flex flex-wrap justify-content-between gap-2 mb-3">
        <div>
            <h1 class="h5 mb-1">{{ $message->subject }}</h1>
            <p class="mb-0 small text-secondary">{{ $message->name }} &lt;{{ $message->email }}&gt;
                @if($message->phone) · {{ $message->phone }}@endif
                · <span class="text-uppercase">{{ $message->category }}</span>
            </p>
        </div>
        <form method="post" action="{{ route('admin.contact-messages.status', $message) }}">
            @csrf @method('put')
            <div class="input-group input-group-sm" style="width:12rem">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="new" @selected($message->status==='new')>Baru</option>
                    <option value="read" @selected($message->status==='read')>Dibaca</option>
                    <option value="replied" @selected($message->status==='replied')>Ditanggapi</option>
                </select>
            </div>
        </form>
    </div>
    <p class="small text-secondary mb-3">{{ $message->created_at->translatedFormat('d F Y, H:i') }}</p>
    <div class="border rounded-3 p-3 bg-body-secondary" style="white-space:pre-wrap">{{ $message->message }}</div>
    <a href="mailto:{{ $message->email }}?subject=Re: {{ urlencode($message->subject) }}" class="btn btn-primary btn-sm mt-3">Balas lewat email</a>
</div>
@endsection
