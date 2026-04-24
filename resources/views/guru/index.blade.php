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
                <option value="{{ $f }}" @selected(request('field')==$f)>{{ $f }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2"><button class="btn btn-primary w-100">Cari</button></div>
    </form>
    <div class="row g-3">
        @forelse($teachers as $t)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100 text-center p-3">
                <div class="mx-auto mb-2 rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center text-primary fw-bold" style="width:80px;height:80px">
                    @if($t->photo) <img src="{{ asset('storage/'.$t->photo) }}" class="rounded-circle w-100 h-100" style="object-fit:cover" alt="">
                    @else {{ strtoupper(\Illuminate\Support\Str::substr($t->name,0,2)) }}
                    @endif
                </div>
                <h6 class="mb-0">{{ $t->name }}</h6>
                <small class="text-secondary">{{ $t->position ?? $t->subject ?? $t->field }}</small>
            </div>
        </div>
        @empty
        <p>Data tidak tersedia.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $teachers->withQueryString()->links() }}</div>
</div></section>
@endsection
