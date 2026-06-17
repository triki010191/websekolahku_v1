<?php

use App\Http\Controllers\Admin\AlumniJobController;
use App\Http\Controllers\Admin\AlumniProfileController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncement;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DownloadController as AdminDownload;
use App\Http\Controllers\Admin\ExtracurricularController as AdminExtracurricular;
use App\Http\Controllers\Admin\FacilityController as AdminFacility;
use App\Http\Controllers\Admin\PartnerController as AdminPartner;
use App\Http\Controllers\Admin\GalleryController as AdminGallery;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\MajorController as AdminMajor;
use App\Http\Controllers\Admin\PageController as AdminPage;
use App\Http\Controllers\Admin\PostController as AdminPost;
use App\Http\Controllers\Admin\PpdbController as AdminPpdb;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacher;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\AlumniAuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TeacherAuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PpdbController;
use App\Http\Controllers\SpmbController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

/* Profil & konten sekolah */
Route::get('/profil/{slug}', [PageController::class, 'show'])->name('profil.show');
Route::get('/jurusan', [MajorController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/{major:slug}', [MajorController::class, 'show'])->name('jurusan.show');
Route::get('/guru', [TeacherController::class, 'index'])->name('guru.index');
Route::get('/guru/masuk', [TeacherAuthController::class, 'showLogin'])->name('guru.login');
Route::post('/guru/masuk', [TeacherAuthController::class, 'login'])->name('guru.login.post')->middleware('throttle:6,1');
Route::middleware(['auth', 'teacher.member'])->group(function () {
    Route::get('/guru/akun', [TeacherAuthController::class, 'dashboard'])->name('guru.member.dashboard');
    Route::post('/guru/akun', [TeacherAuthController::class, 'updateProfile'])->name('guru.member.profile.update');
});
Route::get('/guru/{teacher:slug}', [TeacherController::class, 'show'])->name('guru.show');
Route::get('/galeri', [GalleryController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{album:slug}', [GalleryController::class, 'show'])->name('galeri.show');

/* Berita & info */
Route::get('/berita', [PostController::class, 'index'])->name('berita.index');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('berita.show');
Route::get('/pengumuman', [AnnouncementController::class, 'index'])->name('pengumuman.index');
Route::get('/pengumuman/{slug}', [AnnouncementController::class, 'show'])->name('pengumuman.show');
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.show');
Route::get('/kalender', [EventController::class, 'calendar'])->name('kalender.index');
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/download/berkas/{download}', [DownloadController::class, 'file'])->name('download.file');

/* Fasilitas & program */
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas.index');
Route::get('/fasilitas/{facility:slug}', [FacilityController::class, 'show'])->name('fasilitas.show');
Route::get('/ekstrakurikuler', [ExtracurricularController::class, 'index'])->name('ekstrakurikuler.index');
Route::get('/ekstrakurikuler/{extracurricular:slug}', [ExtracurricularController::class, 'show'])->name('ekstrakurikuler.show');
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/lowongan', [AlumniController::class, 'jobs'])->name('alumni.jobs');
Route::get('/kerjasama', [PartnerController::class, 'index'])->name('kerjasama.index');
Route::get('/kerjasama/{partner:slug}', [PartnerController::class, 'show'])->name('kerjasama.show');

/* Layanan */
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store')->middleware('throttle:20,1');

/* PPDB / SPMB */
Route::get('/spmb-2026', [SpmbController::class, 'index'])->name('spmb.index');
Route::get('/spmb-2026/pra-spmb', [SpmbController::class, 'praSpmb'])->name('spmb.pra-spmb');
Route::get('/spmb-2026/jadwal-tes', [SpmbController::class, 'jadwalTes'])->name('spmb.jadwal-tes');
Route::get('/spmb-2026/tes-bakat-minat', [SpmbController::class, 'tesBakatMinat'])->name('spmb.tes-bakat-minat');
Route::get('/spmb-2026/daftar-ulang', [SpmbController::class, 'daftarUlang'])->name('spmb.daftar-ulang');
Route::get('/spmb-2026/panduan-dapodik', [SpmbController::class, 'panduanDapodik'])->name('spmb.panduan-dapodik');
Route::get('/ppdb', [SpmbController::class, 'index'])->name('ppdb.index');
Route::get('/ppdb/daftar', [PpdbController::class, 'create'])->name('ppdb.create');
Route::get('/ppdb/csrf-token', [PpdbController::class, 'csrfToken'])->name('ppdb.csrf');
Route::get('/ppdb/cek-spmb', [PpdbController::class, 'checkSpmb'])->name('ppdb.check-spmb')->middleware('throttle:60,1');
Route::post('/ppdb/cek-formulir', [PpdbController::class, 'lookup'])->name('ppdb.lookup')->middleware('throttle:30,1');
Route::post('/ppdb/daftar', [PpdbController::class, 'store'])->name('ppdb.store')->middleware('throttle:60,1');
Route::post('/ppdb/draft', [PpdbController::class, 'saveDraft'])->name('ppdb.draft')->middleware('throttle:120,1');
Route::get('/ppdb/sukses/{number}', [PpdbController::class, 'success'])->name('ppdb.success');
Route::get('/ppdb/bukti/{number}', [PpdbController::class, 'pdf'])->name('ppdb.pdf');

/* Autentikasi admin (panel) */
Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.post')->middleware('throttle:6,1');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/* Area alumni (login terpisah dari panel admin) */
Route::get('/alumni/masuk', [AlumniAuthController::class, 'showLogin'])->name('alumni.login');
Route::post('/alumni/masuk', [AlumniAuthController::class, 'login'])->name('alumni.login.post')->middleware('throttle:6,1');
Route::get('/alumni/akun', [AlumniAuthController::class, 'dashboard'])->middleware(['auth', 'alumni.member'])->name('alumni.member.dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'admin.module'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('posts', AdminPost::class)->except('show');
    Route::resource('announcements', AdminAnnouncement::class)->except('show');
    Route::resource('majors', AdminMajor::class)->except('show');
    Route::get('teachers/export/excel', [AdminTeacher::class, 'exportExcel'])->name('teachers.export.excel');
    Route::get('teachers/export/template', [AdminTeacher::class, 'exportTemplate'])->name('teachers.export.template');
    Route::post('teachers/import/excel', [AdminTeacher::class, 'importExcel'])->name('teachers.import.excel');
    Route::post('teachers/{teacher}', [AdminTeacher::class, 'update'])->name('teachers.update-file');
    Route::resource('teachers', AdminTeacher::class)->except('show');

    Route::get('alumni-profiles', [AlumniProfileController::class, 'index'])->name('alumni-profiles.index');
    Route::put('alumni-profiles/{alumniProfile}/verification', [AlumniProfileController::class, 'updateVerification'])->name('alumni-profiles.verification');

    Route::resource('gallery', AdminGallery::class)
        ->except('show')
        ->parameters(['gallery' => 'album']);
    Route::post('gallery/{album}/items', [AdminGallery::class, 'addItem'])->name('gallery.items.store');
    Route::delete('gallery/items/{item}', [AdminGallery::class, 'destroyItem'])->name('gallery.items.destroy');

    Route::get('ppdb/export/excel', [AdminPpdb::class, 'exportExcel'])->name('ppdb.export.excel');
    Route::get('ppdb/{ppdb}/export/pdf', [AdminPpdb::class, 'exportPdf'])->name('ppdb.export.pdf');
    Route::get('ppdb/{ppdb}/kartu-tes', [AdminPpdb::class, 'exportKartuTes'])->name('ppdb.kartu-tes');
    Route::get('ppdb', [AdminPpdb::class, 'index'])->name('ppdb.index');
    Route::get('ppdb/{ppdb}', [AdminPpdb::class, 'show'])->name('ppdb.show');
    Route::put('ppdb/{ppdb}/status', [AdminPpdb::class, 'updateStatus'])->name('ppdb.status');
    Route::delete('ppdb/{ppdb}', [AdminPpdb::class, 'destroy'])->name('ppdb.destroy');

    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::resource('hero-slides', HeroSlideController::class)->except('show');
        Route::resource('downloads', AdminDownload::class)->except('show');
        Route::resource('facilities', AdminFacility::class)->except('show');
        Route::resource('extracurriculars', AdminExtracurricular::class)->except('show');
        Route::resource('partners', AdminPartner::class)->except('show');
        Route::resource('alumni-jobs', AlumniJobController::class)->except('show');
        Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
        Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
        Route::put('contact-messages/{contactMessage}/status', [ContactMessageController::class, 'updateStatus'])->name('contact-messages.status');
        Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
        Route::resource('pages', AdminPage::class)->except('show');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::match(['put', 'post'], 'settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
