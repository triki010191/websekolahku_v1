@php
use App\Support\PpdbFormOptions as O;
$d = $draft;
$val = function($key, $default = '') use ($d) {
    if (old($key) !== null) return old($key);
    if (!$d || !isset($d->$key)) return $default;
    $v = $d->$key;
    if ($v instanceof \DateTimeInterface) return $v->format('Y-m-d');
    return $v ?? $default;
};
$valArr = fn($key) => old($key, $d?->$key ?? []);
$achievements = old('achievements', $d?->achievements ?? [[]]);
$scholarships = old('scholarships', $d?->scholarships ?? [[]]);
@endphp
@extends('layouts.app')
@section('title', 'Formulir Dapodik — '.config('app.name'))
@section('hideFooter', 'true')
@section('content')
<section class="page-hero"><div class="container">
    <h1 class="display-6 fw-bold">Formulir Dapodik</h1>
    <p class="mb-2 opacity-75">Lengkapi data sesuai format Dapodik — SPMB {{ setting('ppdb_year', '2026/2027') }}</p>
    <a href="{{ spmb_route('spmb.panduan-dapodik', '/spmb-2026/panduan-dapodik') }}" class="btn btn-sm btn-outline-light">
        <i class="bi bi-book me-1"></i> Panduan Pengisian &amp; Troubleshooting
    </a>
</div></section>

<section class="py-4 bg-body-tertiary border-bottom">
    <div class="container" style="max-width:960px">
        <div id="wizardProgress" class="d-flex flex-wrap gap-1 justify-content-center small"></div>
        <div id="autosaveStatus" class="text-center small text-secondary mt-2">Draft belum disimpan</div>
        <div class="text-center mt-2">
            <button type="button" id="btnResetForm" class="btn btn-sm btn-outline-danger">
                <i class="bi bi-arrow-counterclockwise me-1"></i> Mulai Formulir Baru (isi untuk siswa lain)
            </button>
        </div>
    </div>
</section>

<section class="py-4"><div class="container" style="max-width:960px">
@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="bi bi-exclamation-circle-fill me-2"></i>{{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if(session('info'))
<div class="alert alert-info alert-dismissible fade show" role="alert">
    <i class="bi bi-info-circle-fill me-2"></i>{{ session('info') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
@if($d?->allowsCorrection())
<div class="alert alert-warning" role="alert">
    <i class="bi bi-pencil-square me-2"></i>
    <strong>Mode Perbaikan Data (Status: Revisi).</strong>
    Data yang sudah Anda kirim tetap tampil di formulir ini. Periksa setiap tahap, perbaiki jika perlu, lalu kirim ulang dari tahap Preview.
</div>
@endif
@if($errors->any())
<div class="alert alert-danger" role="alert">
    <strong>Formulir belum dapat dikirim.</strong> Periksa dan lengkapi data berikut:
    <ul class="mb-0 mt-2 small">
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif
<div id="restoreBanner" class="alert alert-info d-none" role="alert">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
        <span><i class="bi bi-clock-history me-1"></i> Ditemukan isian formulir yang belum dikirim di perangkat ini.</span>
        <span class="d-flex gap-2">
            <button type="button" class="btn btn-sm btn-primary" id="btnRestoreYes">Lanjutkan Isian</button>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="btnRestoreNo">Mulai Baru</button>
        </span>
    </div>
</div>
<div id="submitErrors" class="alert alert-danger d-none" role="alert"></div>
<form id="ppdbWizardForm" method="post" action="{{ route('ppdb.store') }}" novalidate>
    @csrf
    <input type="hidden" name="draft_token" id="draft_token" value="{{ $val('draft_token') }}">

    {{-- STEP 0: SPMB Banten --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3" data-step="0">
        <h5 class="fw-bold text-primary mb-3"><i class="bi bi-card-checklist me-2"></i>Identitas Pendaftaran</h5>
        <div class="alert alert-info small">Masukkan <strong>NISN</strong> (10 digit) Anda sebagai nomor identitas pendaftaran SPMB Provinsi Banten.</div>
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label">Nomor Pendaftaran SPMB Banten / NISN *</label>
                <input class="form-control form-control-lg" name="spmb_banten_number" id="spmb_banten_number" value="{{ $val('spmb_banten_number') }}" placeholder="Contoh: 0113804305" maxlength="10" inputmode="numeric" pattern="[0-9]{10}" required>
                <div class="form-text">Harus 10 digit angka (sesuai NISN Anda).</div>
                <div id="spmbCheckStatus" class="small mt-1 d-none" aria-live="polite"></div>
                @error('spmb_banten_number')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label text-secondary">No. Daftar Ulang (sistem)</label>
                <input class="form-control" id="local_reg_number" value="{{ $val('registration_number') }}" readonly placeholder="Auto saat simpan draft">
            </div>
        </div>
    </div>

    {{-- STEP 1: Data Pribadi --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="1">
        <h5 class="fw-bold mb-3">1. Data Pribadi</h5>
        <h6 class="text-secondary">Identitas Siswa</h6>
        <div class="row g-2">
            <div class="col-md-8"><label class="form-label">Nama Lengkap *</label><input class="form-control" name="full_name" value="{{ $val('full_name') }}" required></div>
            <div class="col-md-4"><label class="form-label">Jenis Kelamin *</label>
                <select name="gender" class="form-select" required><option value="">—</option>
                    <option value="L" @selected($val('gender')==='L')>Laki-laki</option>
                    <option value="P" @selected($val('gender')==='P')>Perempuan</option>
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">NISN *</label><input class="form-control" name="nisn" maxlength="10" value="{{ $val('nisn') }}" required>@error('nisn')<div class="text-danger small">{{ $message }}</div>@enderror</div>
            <div class="col-md-4"><label class="form-label">NIK / No KITAS *</label><input class="form-control" name="nik" value="{{ $val('nik') }}" required></div>
            <div class="col-md-4"><label class="form-label">Tempat Lahir *</label><input class="form-control" name="birth_place" value="{{ $val('birth_place') }}" required></div>
            <div class="col-md-4"><label class="form-label">Tanggal Lahir *</label><input type="date" class="form-control" name="birth_date" value="{{ $val('birth_date') }}" required></div>
            <div class="col-md-4"><label class="form-label">No. Registrasi Akta Kelahiran</label><input class="form-control" name="birth_cert_number" value="{{ $val('birth_cert_number') }}"></div>
            <div class="col-md-4"><label class="form-label">Agama / Kepercayaan *</label>
                <select name="religion" class="form-select" required><option value="">—</option>
                    @foreach(O::religions() as $r)<option value="{{ $r }}" @selected($val('religion')===$r)>{{ $r }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Kewarganegaraan *</label>
                <select name="citizenship" class="form-select" id="citizenship" required><option value="">—</option>
                    @foreach(O::citizenships() as $k=>$v)<option value="{{ $k }}" @selected($val('citizenship')===$k)>{{ $v }}</option>@endforeach
                </select>
            </div>
            <div class="col-md-4" id="countryWrap"><label class="form-label">Nama Negara (WNA) *</label><input class="form-control" name="country_name" value="{{ $val('country_name') }}" data-required-if="citizenship:WNA"></div>
            <div class="col-12" data-required-group="special_needs[]" data-required-label="Berkebutuhan Khusus"><label class="form-label">Berkebutuhan Khusus *</label>
                <div class="row g-1">@foreach(O::specialNeeds() as $sn)
                    <div class="col-md-4 col-lg-3"><label class="form-check small"><input type="checkbox" class="form-check-input" name="special_needs[]" value="{{ $sn }}" @checked(in_array($sn, $valArr('special_needs')))> {{ $sn }}</label></div>
                @endforeach</div>
            </div>
        </div>
        <hr>
        <h6 class="text-secondary">Alamat Tempat Tinggal</h6>
        <div class="row g-2">
            <div class="col-12"><label class="form-label">Alamat Jalan *</label><textarea name="address" class="form-control" rows="2" required>{{ $val('address') }}</textarea></div>
            <div class="col-md-2"><label class="form-label">RT *</label><input class="form-control" name="rt" value="{{ $val('rt') }}" required></div>
            <div class="col-md-2"><label class="form-label">RW *</label><input class="form-control" name="rw" value="{{ $val('rw') }}" required></div>
            <div class="col-md-4"><label class="form-label">Nama Dusun / Kampung *</label><input class="form-control" name="hamlet" value="{{ $val('hamlet') }}" required></div>
            <div class="col-md-4"><label class="form-label">Kelurahan / Desa *</label><input class="form-control" name="village" value="{{ $val('village') }}" required></div>
            <div class="col-md-4"><label class="form-label">Kecamatan *</label><input class="form-control" name="district" value="{{ $val('district') }}" required></div>
            <div class="col-md-4"><label class="form-label">Kode Pos *</label><input class="form-control" name="postal_code" value="{{ $val('postal_code') }}" required></div>
            <div class="col-md-4"><label class="form-label">Latitude</label><input class="form-control" name="latitude" value="{{ $val('latitude') }}"></div>
            <div class="col-md-4"><label class="form-label">Longitude</label><input class="form-control" name="longitude" value="{{ $val('longitude') }}"></div>
        </div>
        <hr>
        <div class="row g-2">
            <div class="col-md-6"><label class="form-label">Tempat Tinggal *</label><select name="residence_type" class="form-select" required><option value="">—</option>@foreach(O::residenceTypes() as $t)<option value="{{ $t }}" @selected($val('residence_type')===$t)>{{ $t }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Moda Transportasi ke Sekolah *</label><select name="transport_mode" class="form-select" required><option value="">—</option>@foreach(O::transportModes() as $t)<option value="{{ $t }}" @selected($val('transport_mode')===$t)>{{ $t }}</option>@endforeach</select></div>
        </div>
        <hr>
        <h6 class="text-secondary">Program Bantuan Sosial</h6>
        <div class="row g-2">
            <div class="col-md-4"><label class="form-label">Nomor KKS</label><input class="form-control" name="kks_number" value="{{ $val('kks_number') }}"></div>
            <div class="col-md-4"><label class="form-label">Anak Keberapa</label><input type="number" min="1" class="form-control" name="child_order" value="{{ $val('child_order') }}"></div>
            <div class="col-md-4"><label class="form-label">Penerima KPS/PKH</label><select name="kps_pkh_receiver" class="form-select"><option value="">—</option>@foreach(O::yesNo() as $k=>$v)<option value="{{ $k }}" @selected((string)$val('kps_pkh_receiver')===(string)$k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Nomor KPS/PKH</label><input class="form-control" name="kps_pkh_number" value="{{ $val('kps_pkh_number') }}"></div>
            <div class="col-md-4"><label class="form-label">Layak PIP dari Sekolah</label><select name="pip_eligible" class="form-select"><option value="">—</option>@foreach(O::yesNo() as $k=>$v)<option value="{{ $k }}" @selected((string)$val('pip_eligible')===(string)$k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Penerima KIP</label><select name="kip_receiver" class="form-select"><option value="">—</option>@foreach(O::yesNo() as $k=>$v)<option value="{{ $k }}" @selected((string)$val('kip_receiver')===(string)$k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Nomor KIP</label><input class="form-control" name="kip_number" value="{{ $val('kip_number') }}"></div>
            <div class="col-md-4"><label class="form-label">Nama di KIP</label><input class="form-control" name="kip_name" value="{{ $val('kip_name') }}"></div>
            <div class="col-md-4"><label class="form-label">Sudah Terima Kartu KIP Fisik</label><select name="kip_card_received" class="form-select"><option value="">—</option>@foreach(O::yesNo() as $k=>$v)<option value="{{ $k }}" @selected((string)$val('kip_card_received')===(string)$k)>{{ $v }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Alasan Layak PIP</label><select name="pip_reason" class="form-select"><option value="">—</option>@foreach(O::pipReasons() as $t)<option value="{{ $t }}" @selected($val('pip_reason')===$t)>{{ $t }}</option>@endforeach</select></div>
        </div>
        <hr>
        <h6 class="text-secondary">Data Perbankan</h6>
        <div class="row g-2">
            <div class="col-md-4"><label class="form-label">Nama Bank</label><input class="form-control" name="bank_name" value="{{ $val('bank_name') }}"></div>
            <div class="col-md-4"><label class="form-label">Nomor Rekening</label><input class="form-control" name="bank_account_number" value="{{ $val('bank_account_number') }}"></div>
            <div class="col-md-4"><label class="form-label">Rekening Atas Nama</label><input class="form-control" name="bank_account_holder" value="{{ $val('bank_account_holder') }}"></div>
        </div>
    </div>

    {{-- STEP 2-4: Orang tua & wali --}}
    @foreach(['father'=>'Ayah Kandung','mother'=>'Ibu Kandung'] as $prefix=>$label)
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="{{ $prefix==='father'?2:3 }}">
        <h5 class="fw-bold mb-3">{{ $prefix==='father'?2:3 }}. Data {{ $label }}</h5>
        <div class="row g-2">
            <div class="col-md-6"><label class="form-label">Nama {{ $label }} *</label><input class="form-control" name="{{ $prefix }}_name" value="{{ $val("{$prefix}_name") }}" required></div>
            <div class="col-md-6"><label class="form-label">NIK *</label><input class="form-control" name="{{ $prefix }}_nik" value="{{ $val("{$prefix}_nik") }}" required></div>
            <div class="col-md-4"><label class="form-label">Tahun Lahir *</label><input type="number" class="form-control" name="{{ $prefix }}_birth_year" value="{{ $val("{$prefix}_birth_year") }}" required></div>
            <div class="col-md-4"><label class="form-label">Pendidikan Terakhir *</label><select name="{{ $prefix }}_education" class="form-select" required><option value="">—</option>@foreach(O::educations() as $e)<option value="{{ $e }}" @selected($val("{$prefix}_education")===$e)>{{ $e }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Pekerjaan *</label><select name="{{ $prefix }}_job" class="form-select" required><option value="">—</option>@foreach(O::occupations() as $e)<option value="{{ $e }}" @selected($val("{$prefix}_job")===$e)>{{ $e }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Penghasilan Bulanan *</label><select name="{{ $prefix }}_income" class="form-select" required><option value="">—</option>@foreach(O::incomes() as $e)<option value="{{ $e }}" @selected($val("{$prefix}_income")===$e)>{{ $e }}</option>@endforeach</select></div>
            <div class="col-12" data-required-group="{{ $prefix }}_special_needs[]" data-required-label="Berkebutuhan Khusus {{ $label }}"><label class="form-label">Berkebutuhan Khusus *</label>
                <div class="row g-1">@foreach(O::specialNeeds() as $sn)
                    <div class="col-md-4 col-lg-3"><label class="form-check small"><input type="checkbox" class="form-check-input" name="{{ $prefix }}_special_needs[]" value="{{ $sn }}" @checked(in_array($sn, $valArr("{$prefix}_special_needs"))) > {{ $sn }}</label></div>
                @endforeach</div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="4">
        <h5 class="fw-bold mb-3">4. Data Wali</h5>
        <div class="row g-2">
            <div class="col-md-6"><label class="form-label">Nama Wali</label><input class="form-control" name="guardian_name" value="{{ $val('guardian_name') }}"></div>
            <div class="col-md-6"><label class="form-label">NIK Wali</label><input class="form-control" name="guardian_nik" value="{{ $val('guardian_nik') }}"></div>
            <div class="col-md-4"><label class="form-label">Tahun Lahir</label><input type="number" class="form-control" name="guardian_birth_year" value="{{ $val('guardian_birth_year') }}"></div>
            <div class="col-md-4"><label class="form-label">Pendidikan Terakhir</label><select name="guardian_education" class="form-select"><option value="">—</option>@foreach(O::educations() as $e)<option value="{{ $e }}" @selected($val('guardian_education')===$e)>{{ $e }}</option>@endforeach</select></div>
            <div class="col-md-4"><label class="form-label">Pekerjaan</label><select name="guardian_job" class="form-select"><option value="">—</option>@foreach(O::occupations() as $e)<option value="{{ $e }}" @selected($val('guardian_job')===$e)>{{ $e }}</option>@endforeach</select></div>
            <div class="col-md-6"><label class="form-label">Penghasilan Bulanan</label><select name="guardian_income" class="form-select"><option value="">—</option>@foreach(O::incomes() as $e)<option value="{{ $e }}" @selected($val('guardian_income')===$e)>{{ $e }}</option>@endforeach</select></div>
        </div>
    </div>

    {{-- STEP 5: Kontak --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="5">
        <h5 class="fw-bold mb-3">5. Data Kontak</h5>
        <div class="row g-2">
            <div class="col-md-4"><label class="form-label">Telepon Rumah</label><input class="form-control" name="home_phone" value="{{ $val('home_phone') }}"></div>
            <div class="col-md-4"><label class="form-label">Nomor Handphone *</label><input class="form-control" name="phone" value="{{ $val('phone') }}" required></div>
            <div class="col-md-4"><label class="form-label">Email</label><input type="email" class="form-control" name="email" value="{{ $val('email') }}"></div>
        </div>
    </div>

    {{-- STEP 6: Periodik --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="6">
        <h5 class="fw-bold mb-3">6. Data Periodik</h5>
        <div class="row g-2">
            <div class="col-md-3"><label class="form-label">Tinggi Badan (cm) *</label><input type="number" class="form-control" name="height_cm" value="{{ $val('height_cm') }}" required></div>
            <div class="col-md-3"><label class="form-label">Berat Badan (kg) *</label><input type="number" class="form-control" name="weight_kg" value="{{ $val('weight_kg') }}" required></div>
            <div class="col-md-6"><label class="form-label">Jarak Tempat Tinggal ke Sekolah *</label><select name="distance_category" class="form-select" required><option value="">—</option>@foreach(O::distanceCategories() as $t)<option value="{{ $t }}" @selected($val('distance_category')===$t)>{{ $t }}</option>@endforeach</select></div>
            <div class="col-md-3"><label class="form-label">Jarak Aktual (km)</label><input type="number" step="0.1" class="form-control" name="distance_km" value="{{ $val('distance_km') }}"></div>
            <div class="col-md-3"><label class="form-label">Waktu Tempuh (Jam)</label><input type="number" min="0" max="23" class="form-control" name="travel_hours" value="{{ $val('travel_hours') }}"></div>
            <div class="col-md-3"><label class="form-label">Waktu Tempuh (Menit)</label><input type="number" min="0" max="59" class="form-control" name="travel_minutes" value="{{ $val('travel_minutes') }}"></div>
            <div class="col-md-3"><label class="form-label">Jumlah Saudara Kandung</label><input type="number" min="0" class="form-control" name="siblings_count" value="{{ $val('siblings_count') }}"></div>
        </div>
    </div>

    {{-- STEP 7: Prestasi --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="7">
        <h5 class="fw-bold mb-3">7. Data Prestasi</h5>
        <div id="achievementsWrap">
            @foreach($achievements as $i=>$ach)
            <div class="achievement-row border rounded p-3 mb-2" data-index="{{ $i }}">
                <div class="row g-2">
                    <div class="col-md-4"><label class="form-label">Jenis</label><select name="achievements[{{ $i }}][type]" class="form-select"><option value="">—</option>@foreach(O::achievementTypes() as $t)<option value="{{ $t }}" @selected(($ach['type']??'')===$t)>{{ $t }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Tingkat</label><select name="achievements[{{ $i }}][level]" class="form-select"><option value="">—</option>@foreach(O::achievementLevels() as $t)<option value="{{ $t }}" @selected(($ach['level']??'')===$t)>{{ $t }}</option>@endforeach</select></div>
                    <div class="col-md-4"><label class="form-label">Tahun</label><input type="number" class="form-control" name="achievements[{{ $i }}][year]" value="{{ $ach['year']??'' }}"></div>
                    <div class="col-md-6"><label class="form-label">Nama Prestasi</label><input class="form-control" name="achievements[{{ $i }}][name]" value="{{ $ach['name']??'' }}"></div>
                    <div class="col-md-4"><label class="form-label">Penyelenggara</label><input class="form-control" name="achievements[{{ $i }}][organizer]" value="{{ $ach['organizer']??'' }}"></div>
                    <div class="col-md-2"><label class="form-label">Peringkat</label><input class="form-control" name="achievements[{{ $i }}][rank]" value="{{ $ach['rank']??'' }}"></div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 btn-remove-row">Hapus</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addAchievement">+ Tambah Prestasi</button>
    </div>

    {{-- STEP 8: Beasiswa --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="8">
        <h5 class="fw-bold mb-3">8. Data Beasiswa</h5>
        <div id="scholarshipsWrap">
            @foreach($scholarships as $i=>$sch)
            <div class="scholarship-row border rounded p-3 mb-2" data-index="{{ $i }}">
                <div class="row g-2">
                    <div class="col-md-4"><label class="form-label">Jenis Beasiswa</label><select name="scholarships[{{ $i }}][type]" class="form-select"><option value="">—</option>@foreach(O::scholarshipTypes() as $t)<option value="{{ $t }}" @selected(($sch['type']??'')===$t)>{{ $t }}</option>@endforeach</select></div>
                    <div class="col-md-8"><label class="form-label">Keterangan</label><input class="form-control" name="scholarships[{{ $i }}][description]" value="{{ $sch['description']??'' }}"></div>
                    <div class="col-md-3"><label class="form-label">Tahun Mulai</label><input type="number" class="form-control" name="scholarships[{{ $i }}][year_start]" value="{{ $sch['year_start']??'' }}"></div>
                    <div class="col-md-3"><label class="form-label">Tahun Selesai</label><input type="number" class="form-control" name="scholarships[{{ $i }}][year_end]" value="{{ $sch['year_end']??'' }}"></div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger mt-2 btn-remove-row">Hapus</button>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addScholarship">+ Tambah Beasiswa</button>
    </div>

    {{-- STEP 9: Registrasi --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="9">
        <h5 class="fw-bold mb-3">9. Data Registrasi Peserta Didik</h5>
        <div class="row g-2">
            <div class="col-md-6"><label class="form-label">Kompetensi Keahlian *</label>
                <select name="major_id" class="form-select" required><option value="">Pilih jurusan</option>
                    @foreach($majors as $m)<option value="{{ $m->id }}" @selected((string)$val('major_id')===(string)$m->id)>{{ $m->name }}</option>@endforeach
                </select>@error('major_id')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6"><label class="form-label">Jenis Pendaftaran *</label>
                <select name="registration_type" class="form-select" required><option value="">—</option>@foreach(O::registrationTypes() as $k=>$v)<option value="{{ $k }}" @selected($val('registration_type')===$k)>{{ $v }}</option>@endforeach</select>
            </div>
            <div class="col-md-4"><label class="form-label">NIS *</label><input class="form-control" name="nis" value="{{ $val('nis') }}" required></div>
            <div class="col-md-4">
                <label class="form-label">Tanggal Masuk Sekolah</label>
                <input type="date" class="form-control bg-body-secondary" value="2026-07-13" readonly tabindex="-1" aria-readonly="true">
                <input type="hidden" name="school_entry_date" value="2026-07-13">
                <div class="form-text">Masuk 13 Juli 2026 (otomatis, tidak dapat diubah).</div>
            </div>
            <div class="col-md-4"><label class="form-label">Asal Sekolah *</label><input class="form-control" name="previous_school" value="{{ $val('previous_school') }}" required></div>
            <div class="col-md-4"><label class="form-label">Nomor Peserta Ujian</label><input class="form-control" name="exam_number" value="{{ $val('exam_number') }}"></div>
            <div class="col-md-4"><label class="form-label">Nomor Seri Ijazah</label><input class="form-control" name="diploma_serial" value="{{ $val('diploma_serial') }}"></div>
            <div class="col-md-4"><label class="form-label">Nomor Seri SKHUS/SKHUN</label><input class="form-control" name="skhus_serial" value="{{ $val('skhus_serial') }}"></div>
        </div>
    </div>

    {{-- STEP 10: Preview --}}
    <div class="wizard-step card border-0 shadow-sm p-4 mb-3 d-none" data-step="10">
        <h5 class="fw-bold mb-3">10. Preview &amp; Kirim</h5>
        <div id="previewContent" class="small bg-body-tertiary rounded p-3 mb-3" style="max-height:420px;overflow:auto"></div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="data_declaration" value="1" id="data_declaration" @checked(old('data_declaration'))>
            <label class="form-check-label" for="data_declaration">Saya menyatakan bahwa seluruh data yang saya isi adalah benar dan dapat dipertanggungjawabkan.</label>
        </div>
        @error('data_declaration')<div class="text-danger small mb-2">{{ $message }}</div>@enderror
    </div>

    <div id="stepWarning" class="alert alert-warning d-none py-2 small mb-2" role="alert"></div>

    <div class="d-flex justify-content-between gap-2 sticky-bottom bg-body border-top py-3 px-2 mt-2" style="bottom:0;z-index:10">
        <button type="button" class="btn btn-outline-secondary" id="btnPrev" disabled>Kembali</button>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-outline-primary" id="btnSaveDraft"><i class="bi bi-cloud-arrow-up"></i> Simpan Draft</button>
            <button type="button" class="btn btn-primary" id="btnNext">Lanjut</button>
            <button type="submit" class="btn btn-success d-none" id="btnSubmit"><i class="bi bi-send"></i> Kirim Formulir</button>
        </div>
    </div>
</form>
</div></section>
@endsection

@push('scripts')
<script>
window.PPDB_WIZARD = {
    storeUrl: @json(route('ppdb.store')),
    draftUrl: @json(route('ppdb.draft')),
    createUrl: @json(route('ppdb.create')),
    csrfUrl: @json(route('ppdb.csrf')),
    checkSpmbUrl: @json(route('ppdb.check-spmb')),
    csrf: @json(csrf_token()),
    isCorrectionMode: @json((bool) ($d?->allowsCorrection())),
    serverDraftToken: @json($d?->draft_token),
    hasValidationErrors: @json($errors->any()),
    stepLabels: @json(array_merge(['Identitas SPMB'], O::stepLabels())),
    achievementTypes: @json(O::achievementTypes()),
    achievementLevels: @json(O::achievementLevels()),
    scholarshipTypes: @json(O::scholarshipTypes()),
};
</script>
@if (is_file(public_path('js/ppdb-wizard.js')))
<script>{!! str_replace('</script>', '<\/script>', file_get_contents(public_path('js/ppdb-wizard.js'))) !!}</script>
@else
<script src="{{ asset('js/ppdb-wizard.js') }}"></script>
@endif
@endpush
