@extends('layouts.app')
@section('title', 'Kontak — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Hubungi Kami</h1></div></section>
<section class="py-5"><div class="container">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                <h6 class="text-uppercase text-muted">Alamat</h6>
                <p class="mb-0">{{ setting('contact_address') }}</p>
            </div></div>
            <div class="card border-0 shadow-sm mb-3"><div class="card-body">
                <h6 class="text-uppercase text-muted">Kontak</h6>
                <p class="mb-0">Telp: {{ setting('contact_phone') }}<br>WA: {{ setting('contact_whatsapp') }}<br>Email: {{ setting('contact_email') }}</p>
            </div></div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4">
                <h4 class="mb-3">Kirim Pesan</h4>
                <form method="post" action="{{ route('kontak.store') }}">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6"><label class="form-label">Nama *</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
                        <div class="col-md-6"><label class="form-label">Email *</label><input type="email" class="form-control" name="email" value="{{ old('email') }}" required></div>
                        <div class="col-md-6"><label class="form-label">No HP</label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
                        <div class="col-md-6">
                            <label class="form-label">Kategori *</label>
                            <select name="category" class="form-select" required>
                                @foreach(['umum','ppdb','alumni','kerjasama','lainnya'] as $c)
                                <option value="{{ $c }}" @selected(old('category', 'umum')===$c)>{{ strtoupper($c) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12"><label class="form-label">Subjek *</label><input class="form-control" name="subject" value="{{ old('subject') }}" required></div>
                        <div class="col-12"><label class="form-label">Pesan *</label><textarea name="message" class="form-control" rows="5" minlength="10" required>{{ old('message') }}</textarea>
                            @error('message')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3">Kirim</button>
                </form>
            </div>
        </div>
    </div>
</div></section>
@endsection
