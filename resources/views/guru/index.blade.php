@extends('layouts.app')
@section('title', 'Guru & TU — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Guru &amp; Tenaga Kependidikan</h1></div></section>
<section class="py-5"><div class="container">
    <form method="get" class="row g-2 mb-4">
        <div class="col-md-4"><input type="search" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="field" class="form-select" onchange="this.form.submit()">
                <option value="">Semua bidang</option>
                @foreach($fields as $f)
                <option value="{{ $f }}" @selected(request('field')===$f)>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
    </form>
    <div class="row g-3">
        @forelse($teachers as $t)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('guru.show', $t) }}" class="text-decoration-none text-body">
                <div class="card border-0 shadow-sm h-100 text-center p-3 guru-card">
                    <div class="guru-card-photo">
                        <div class="guru-photo-ring">
                            <img src="{{ $t->photo_url }}" alt="{{ $t->name }}" loading="lazy" width="80" height="80">
                        </div>
                    </div>
                    <h6 class="mb-0">{{ $t->name }}</h6>
                    <small class="text-secondary">{{ $t->position }}</small>
                    @if($t->subject)
                    <small class="d-block text-muted mt-1">{{ $t->subject }}</small>
                    @endif
                </div>
            </a>
        </div>
        @empty
        <p>Data tidak tersedia.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $teachers->withQueryString()->links() }}</div>
</div></section>
@endsection
