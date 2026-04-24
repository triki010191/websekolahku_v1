# SMKN 8 Pandeglang — Website (Laravel)

Proyek Laravel berada di **root folder ini** (`app/`, `routes/`, `public/`, `vendor/`, …).

## Akses di XAMPP

- **Utama:** `http://localhost/websekolah_v1/public/`
- `index.php` di root hanya **mengalihkan** ke `public/` (front controller Laravel).

Atur **`APP_URL`** di `.env` sama dengan URL yang Anda buka (contoh `http://localhost/websekolah_v1/public`).

## Dokumentasi lengkap

Lihat **`README_LARAVEL.md`** (instalasi, role admin, troubleshooting `tempnam` / izin `storage`).

## Folder lama

Jika masih ada **`laravel-app/`** (sisa cache Apache), hapus manual:

`sudo rm -rf laravel-app`

(File cache milik user `daemon` bisa menolak penghapusan tanpa `sudo`.)
