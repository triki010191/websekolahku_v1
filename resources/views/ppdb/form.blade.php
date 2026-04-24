@extends('layouts.app')
@section('title', 'Formulir SPMB — '.config('app.name'))
@section('content')
<section class="page-hero"><div class="container"><h1 class="display-6 fw-bold">Formulir Pendaftaran</h1></div></section>
<section class="py-5"><div class="container" style="max-width:800px">
    <form method="post" action="{{ route('ppdb.store') }}" enctype="multipart/form-data" class="card border-0 shadow-sm p-4">
        @csrf
        <h5 class="mb-3">Data Pribadi &amp; Orang Tua</h5>
        <div class="row g-2">
            <div class="col-md-6">
                <label class="form-label">Pilihan Jurusan *</label>
                <select name="major_id" class="form-select" required>
                    <option value="">Pilih</option>
                    @foreach($majors as $m)
                    <option value="{{ $m->id }}" @selected(old('major_id')==$m->id)>{{ $m->name }}</option>
                    @endforeach
                </select>
                @error('major_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
                <label class="form-label">Jalur *</label>
                <select name="pathway" class="form-select" required>
                    @foreach(['zonasi','prestasi','afirmasi','mutasi'] as $p)
                    <option value="{{ $p }}" @selected(old('pathway')===$p)>{{ ucfirst($p) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-8"><label class="form-label">Nama Lengkap *</label><input class="form-control" name="full_name" value="{{ old('full_name') }}" required></div>
            <div class="col-md-4"><label class="form-label">NISN *</label><input class="form-control" name="nisn" value="{{ old('nisn') }}" maxlength="10" required>
                @error('nisn')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4"><label class="form-label">Jenis Kelamin *</label>
                <select name="gender" class="form-select" required>
                    <option value="L" @selected(old('gender')==='L')>Laki-laki</option>
                    <option value="P" @selected(old('gender')==='P')>Perempuan</option>
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Agama</label><input class="form-control" name="religion" value="{{ old('religion') }}"></div>
            <div class="col-md-4"><label class="form-label">Asal Sekolah *</label><input class="form-control" name="previous_school" value="{{ old('previous_school') }}" required></div>
            <div class="col-12"><label class="form-label">Alamat</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
            <div class="col-md-6"><label class="form-label">No HP</label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ old('email') }}"></div>
            <div class="col-md-6"><label class="form-label">Nama Ayah</label><input class="form-control" name="father_name" value="{{ old('father_name') }}"></div>
            <div class="col-md-6"><label class="form-label">Nama Ibu</label><input class="form-control" name="mother_name" value="{{ old('mother_name') }}"></div>
            <div class="col-md-6"><label class="form-label">No HP Orang Tua</label><input class="form-control" name="parent_phone" value="{{ old('parent_phone') }}"></div>
        </div>
        <h5 class="mt-4 mb-2">Berkas (opsional)</h5>
        <div class="row g-2">
            <div class="col-md-6"><label class="form-label">Foto / dokumen scan</label><input type="file" class="form-control" name="doc_photo" accept="image/*"></div>
        </div>
        <button class="btn btn-primary mt-4">Kirim Pendaftaran</button>
    </form>
</div></section>
@endsection
