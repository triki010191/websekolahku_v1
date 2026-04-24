<?php

use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\LoginController;
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
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncement;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGallery;
use App\Http\Controllers\Admin\MajorController as AdminMajor;
use App\Http\Controllers\Admin\PostController as AdminPost;
use App\Http\Controllers\Admin\PpdbController as AdminPpdb;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AlumniProfileController;
use App\Http\Controllers\Admin\TeacherController as AdminTeacher;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AlumniAuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

/* Profil & konten sekolah */
Route::get('/profil/{slug}', [PageController::class, 'show'])->name('profil.show');
Route::get('/jurusan', [MajorController::class, 'index'])->name('jurusan.index');
Route::get('/jurusan/{major:slug}', [MajorController::class, 'show'])->name('jurusan.show');
Route::get('/guru', [TeacherController::class, 'index'])->name('guru.index');
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

/* Fasilitas & program */
Route::get('/fasilitas', [FacilityController::class, 'index'])->name('fasilitas.index');
Route::get('/fasilitas/{facility:slug}', [FacilityController::class, 'show'])->name('fasilitas.show');
Route::get('/ekstrakurikuler', [ExtracurricularController::class, 'index'])->name('ekstrakurikuler.index');
Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/lowongan', [AlumniController::class, 'jobs'])->name('alumni.jobs');
Route::get('/kerjasama', [PartnerController::class, 'index'])->name('kerjasama.index');

/* Layanan */
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('kontak.index');
Route::post('/kontak', [ContactController::class, 'store'])->name('kontak.store');

/* PPDB */
Route::get('/ppdb', [PpdbController::class, 'index'])->name('ppdb.index');
Route::get('/ppdb/daftar', [PpdbController::class, 'create'])->name('ppdb.create');
Route::post('/ppdb/daftar', [PpdbController::class, 'store'])->name('ppdb.store');
Route::get('/ppdb/sukses/{number}', [PpdbController::class, 'success'])->name('ppdb.success');

/* Autentikasi admin (panel) */
Route::get('/admin/login', [LoginController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('admin.login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/* Area alumni (login terpisah dari panel admin) */
Route::get('/alumni/masuk', [AlumniAuthController::class, 'showLogin'])->name('alumni.login');
Route::post('/alumni/masuk', [AlumniAuthController::class, 'login'])->name('alumni.login.post');
Route::get('/alumni/akun', [AlumniAuthController::class, 'dashboard'])->middleware(['auth', 'alumni.member'])->name('alumni.member.dashboard');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin', 'admin.module'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::resource('posts', AdminPost::class)->except('show');
    Route::resource('announcements', AdminAnnouncement::class)->except('show');
    Route::resource('majors', AdminMajor::class)->except('show');
    Route::resource('teachers', AdminTeacher::class)->except('show');

    Route::get('alumni-profiles', [AlumniProfileController::class, 'index'])->name('alumni-profiles.index');
    Route::put('alumni-profiles/{alumniProfile}/verification', [AlumniProfileController::class, 'updateVerification'])->name('alumni-profiles.verification');

    Route::resource('gallery', AdminGallery::class)
        ->except('show')
        ->parameters(['gallery' => 'album']);
    Route::post('gallery/{album}/items', [AdminGallery::class, 'addItem'])->name('gallery.items.store');
    Route::delete('gallery/items/{item}', [AdminGallery::class, 'destroyItem'])->name('gallery.items.destroy');

    Route::get('ppdb', [AdminPpdb::class, 'index'])->name('ppdb.index');
    Route::get('ppdb/{ppdb}', [AdminPpdb::class, 'show'])->name('ppdb.show');
    Route::put('ppdb/{ppdb}/status', [AdminPpdb::class, 'updateStatus'])->name('ppdb.status');
    Route::delete('ppdb/{ppdb}', [AdminPpdb::class, 'destroy'])->name('ppdb.destroy');

    Route::middleware('role:super_admin')->group(function () {
        Route::resource('users', UserController::class)->except('show');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::match(['put', 'post'], 'settings', [SettingController::class, 'update'])->name('settings.update');
    });
});
