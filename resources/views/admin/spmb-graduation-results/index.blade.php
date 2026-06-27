@extends('layouts.admin')
@section('title', 'Hasil Seleksi SPMB')
@section('admin')
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
    <div>
        <h1 class="h4 mb-1">Pengumuman Hasil Seleksi SPMB</h1>
        <p class="small text-secondary mb-0">Kelola daftar siswa diterima untuk halaman pengumuman kelulusan.</p>
    </div>
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('spmb.pengumuman-kelulusan') }}" class="btn btn-outline-secondary btn-sm" target="_blank"><i class="bi bi-box-arrow-up-right"></i> Lihat Halaman</a>
        <a href="{{ route('admin.spmb-graduation-results.export.template') }}" class="btn btn-outline-secondary btn-sm"><i class="bi bi-file-earmark-spreadsheet"></i> Template Import</a>
        <a href="{{ route('admin.spmb-graduation-results.export.excel') }}" class="btn btn-outline-success btn-sm"><i class="bi bi-download"></i> Export Excel</a>
        <a href="{{ route('admin.spmb-graduation-results.create') }}" class="btn btn-primary btn-sm">+ Tambah Siswa</a>
    </div>
</div>

<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm p-3 h-100">
            <div class="small text-secondary">Total siswa diterima</div>
            <div class="fs-4 fw-bold text-success">{{ $total }}</div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card border-0 shadow-sm p-3 h-100">
            <form method="post" action="{{ route('admin.spmb-graduation-results.toggle-publish') }}" class="d-flex flex-wrap align-items-center gap-3">
                @csrf
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="publishedToggle" name="published" value="1" @checked($isPublished) onchange="this.form.submit()">
                    <label class="form-check-label fw-semibold" for="publishedToggle">Publikasikan di website</label>
                </div>
                <span class="small text-secondary">
                    @if($isPublished)
                    <span class="text-success"><i class="bi bi-check-circle"></i> Halaman pengumuman aktif</span>
                    @else
                    <span class="text-warning"><i class="bi bi-eye-slash"></i> Halaman menampilkan "belum tersedia"</span>
                    @endif
                </span>
            </form>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm p-3 mb-3">
    <form method="post" action="{{ route('admin.spmb-graduation-results.import.excel') }}" enctype="multipart/form-data" class="d-flex flex-wrap gap-2 align-items-end">
        @csrf
        <div class="flex-grow-1" style="min-width:220px">
            <label class="form-label small mb-1">Import dari Excel / CSV</label>
            <input type="file" name="file" class="form-control form-control-sm" accept=".xlsx,.xls,.csv" required>
        </div>
        <button class="btn btn-sm btn-primary">Import</button>
    </form>
    <p class="small text-secondary mb-0 mt-2">
        Unduh template, isi kolom <strong>NO. URUT</strong> s/d <strong>DITERIMA PADA JURUSAN</strong>, lalu import.
        Baris dengan NISN sama akan diperbarui.
    </p>
    <details class="small mt-2">
        <summary class="text-primary" style="cursor:pointer">Pilihan jurusan yang valid</summary>
        <ul class="mb-0 mt-1">
            @foreach(\App\Models\SpmbGraduationResult::ACCEPTED_MAJORS as $major)
            <li>{{ $major }}</li>
            @endforeach
        </ul>
    </details>
</div>

<div class="table-responsive card border-0 shadow-sm">
    <table class="table table-hover table-sm mb-0">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>No. Daftar</th>
                <th>NISN</th>
                <th>Nama Lengkap</th>
                <th>JK</th>
                <th>Asal Sekolah</th>
                <th>Jurusan</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($results as $r)
            <tr>
                <td>{{ $r->sort_order }}</td>
                <td>{{ $r->registration_number ?? '—' }}</td>
                <td>{{ $r->nisn }}</td>
                <td>{{ $r->full_name }}</td>
                <td>{{ $r->gender }}</td>
                <td>{{ $r->origin_school ?? '—' }}</td>
                <td><span class="badge text-bg-primary">{{ $r->accepted_major }}</span></td>
                <td class="text-end text-nowrap">
                    <a href="{{ route('admin.spmb-graduation-results.edit', $r) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form class="d-inline" method="post" action="{{ route('admin.spmb-graduation-results.destroy', $r) }}">
                        @csrf @method('delete')
                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-secondary py-4">Belum ada data. Import Excel atau tambah manual.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $results->links() }}
@endsection
