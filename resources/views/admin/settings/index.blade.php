@extends('layouts.admin')
@section('title', 'Pengaturan')
@section('admin')
<h1 class="h4 mb-4">Pengaturan Website</h1>
<form method="post" action="{{ route('admin.settings.update') }}" class="vstack gap-4">
    @csrf
    @method('put')
    @foreach($settings as $group => $rows)
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-bold text-uppercase small text-secondary">{{ $group }}</div>
        <div class="card-body">
            @foreach($rows as $s)
            <div class="mb-3">
                <label class="form-label small text-muted mb-0">{{ $s->key }}</label>
                @if($s->type==='image')
                <input type="file" class="form-control" name="files[{{ $s->key }}]">
                @if($s->value) <div class="small">Saat ini: {{ $s->value }}</div> @endif
                @else
                <input type="text" class="form-control" name="{{ $s->key }}" value="{{ old($s->key, $s->value) }}">
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
    <button class="btn btn-primary">Simpan semua</button>
</form>
@endsection
