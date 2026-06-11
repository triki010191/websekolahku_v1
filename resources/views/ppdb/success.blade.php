@extends('layouts.app')
@section('title', session('lookup') ? 'Formulir Dapodik ditemukan' : 'Formulir Dapodik berhasil dikirim')
@section('content')
<section class="py-5 text-center">
    <div class="container" style="max-width:640px">
        <div class="text-success display-1 mb-3"><i class="bi bi-check-circle"></i></div>
        @if(session('lookup'))
        <h1 class="h3 fw-bold">Formulir Daftar Ulang Ditemukan</h1>
        <p class="text-secondary">Data formulir Dapodik Anda sudah tersimpan. Anda dapat mengunduh ulang PDF isian formulir di bawah.</p>
        @else
        <h1 class="h3 fw-bold">Formulir Daftar Ulang Berhasil Dikirim</h1>
        <p class="text-secondary">Terima kasih, data Dapodik Anda telah kami terima dan tersimpan di sistem sekolah.</p>
        @endif

        <div class="card border-0 shadow-sm text-start p-4 my-4">
            <div class="row g-2 small">
                <div class="col-sm-6"><span class="text-secondary">No. Daftar Ulang</span><div class="fw-bold fs-5 text-primary">{{ $reg->registration_number }}</div></div>
                <div class="col-sm-6"><span class="text-secondary">No. SPMB Banten</span><div class="fw-bold">{{ $reg->spmb_banten_number }}</div></div>
                <div class="col-sm-6"><span class="text-secondary">Nama</span><div class="fw-semibold">{{ $reg->full_name }}</div></div>
                <div class="col-sm-6"><span class="text-secondary">Jurusan</span><div class="fw-semibold">{{ $reg->major?->name }}</div></div>
                <div class="col-12"><span class="text-secondary">Status</span><div><span class="badge {{ $reg->statusBadgeClass() }}">{{ $reg->statusLabel() }}</span></div></div>
            </div>
        </div>

        @if(session('info'))
        <div class="alert alert-info small text-start">{{ session('info') }}</div>
        @elseif(!$reg->allowsCorrection())
        <div class="alert alert-secondary small text-start">
            <i class="bi bi-lock me-1"></i>
            Formulir sudah terkunci dan tidak dapat diedit pada status ini. Hubungi panitia jika ada kesalahan data.
        </div>
        @endif

        <div class="alert alert-info small text-start">
            <i class="bi bi-info-circle me-1"></i>
            PDF formulir {{ session('lookup') ? 'akan diunduh otomatis' : 'Anda akan diunduh otomatis' }}. Jika tidak muncul, klik tombol di bawah.
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a href="{{ $pdfUrl }}" id="btnDownloadPdf" class="btn btn-primary btn-lg" download="formulir-dapodik-{{ $reg->registration_number }}.pdf"><i class="bi bi-file-earmark-pdf"></i> Unduh PDF Formulir</a>
            @if($reg->allowsCorrection())
            <a href="{{ route('ppdb.create') }}" class="btn btn-warning btn-lg"><i class="bi bi-pencil-square"></i> Perbaiki Formulir</a>
            @endif
            @if(setting('ppdb_is_open', false))
            <a href="{{ route('ppdb.create') }}" class="btn btn-outline-success"><i class="bi bi-person-plus"></i> Isi Formulir Siswa Lain</a>
            @endif
            <a href="{{ route('spmb.index') }}" class="btn btn-outline-primary">Info SPMB</a>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">Beranda</a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
(function () {
    const pdfUrl = @json($pdfUrl);
    const filename = @json('formulir-dapodik-'.$reg->registration_number.'.pdf');

    function triggerDownload() {
        const link = document.createElement('a');
        link.href = pdfUrl;
        link.download = filename;
        link.rel = 'noopener';
        link.style.display = 'none';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    setTimeout(triggerDownload, 800);
})();
</script>
@endpush
