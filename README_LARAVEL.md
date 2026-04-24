# SMKN 8 Pandeglang — Aplikasi Laravel (Bootstrap 5 + MySQL)

Aplikasi website resmi sekolah dengan **Laravel 12**, tampilan **Bootstrap 5.3** (via CDN + `public/css/app.css`), basis data **MySQL** (atau **SQLite** untuk pengembangan cepat), panel admin, dan isi contoh lewat seeder.

## Struktur singkat

| Area | Keterangan |
|------|------------|
| `routes/web.php` | Rute publik + `admin/*` (auth, CRUD) |
| `resources/views` | Blade: layout, beranda, profil, berita, PPDB, admin, dll. |
| `app/Http/Controllers` | Controller publik + `Admin\` |
| `database/migrations` | Skema: berita, pengumuman, jurusan, guru, PPDB, galeri, alumni, FAQ, unduhan, pengaturan… |
| `database/seeders` | Data awal: user, setting, kategori, konten demo |

## Instalasi (MySQL — produksi / XAMPP)

1. Buat database: `mysql -u root -p < database/schema_mysql.sql`
2. Di **folder proyek ini** (root), salin environment:
   - `cp .env.example .env`
3. Edit `.env`:
   - `DB_CONNECTION=mysql`
   - `DB_HOST=127.0.0.1`
   - `DB_DATABASE=smkn8_pandeglang`
   - `DB_USERNAME=root` (atau user khusus)
   - `DB_PASSWORD=` (sesuaikan)
   - `APP_URL=http://localhost/websekolah_v1/public` (sesuaikan path XAMPP)
4. `composer install` (jika belum)
5. `php artisan key:generate`
6. `php artisan migrate --seed`
7. `php artisan storage:link` (file upload berita, galeri, logo)
8. Akses:
   - Website: `APP_URL/`
   - Admin: `APP_URL/admin/login`  
   - Default super admin: `admin@smkn8pandeglang.sch.id` / `password` (ganti segera)

## Error `tempnam()` / Blade (HTTP 500) di XAMPP

Proses **Apache** biasanya jalan sebagai user lain dari folder proyek Anda, sehingga **gagal menulis** `storage/framework/views` saat kompilasi Blade, memicu peringatan `tempnam()`.

**Lokal (bukan produksi):**

```bash
cd /path/ke/websekolah_v1
chmod -R 775 storage bootstrap/cache
# jika masih error, hanya di mesin pribadi:
chmod -R 777 storage bootstrap/cache
php artisan optimize:clear
```

**Produksi:** jangan `777`; set `chown`/`chgrp` ke user yang menjalankan PHP-FPM atau Apache, izin `775` cukup.

## Error session: `file_put_contents(.../storage/framework/sessions/...): Permission denied`

Proses **Apache** (`daemon` / `_www`) tidak bisa menulis file session. **Cepat (lokal):** di `.env` set `SESSION_DRIVER=cookie` dan `SESSION_ENCRYPT=true` (sudah default di proyek ini), lalu `php artisan config:clear`.  
**Atau** perbaiki owner/izin: `sudo chown -R daemon:admin storage` (sesuaikan user proses web) dan `chmod -R 775 storage`.

## Instalasi cepat (SQLite)

1. `touch database/database.sqlite`
2. Di `.env`: `DB_CONNECTION=sqlite` dan `DB_DATABASE=/path/ke/laravel-app/database/database.sqlite` (path absolut) atau cukup `DB_DATABASE=database/database.sqlite` relatif ke path project, sesuai `config/database.php`
3. `php artisan migrate --seed` dan `php artisan storage:link`

## Peran pengguna (role)

- `super_admin` — semua modul + **User** + **Pengaturan**
- `admin_berita` — hanya modul **Berita** (CRUD `posts`)
- `admin_alumni` — hanya **Data alumni** (verifikasi profil)
- `alumni` — login di **`/alumni/masuk`**, bukan panel admin; akun **admin** lewat `admin/login`

## Tes

```bash
php artisan test
```

Menggunakan database SQLite in-memory; `ExampleTest` menjalankan `RefreshDatabase` + `seed` sebelum memanggil `GET /`.

## Catatan

- Tema **light/dark** disimpan di `localStorage` (tombol di header) — Bootstrap `data-bs-theme`.
- **Cache** `Setting::get` memakai `Cache::rememberForever` — jika edit pengaturan, cache dibersihkan di model.
- Prototype HTML statis ada di folder induk `websekolah_v1` (bukan wajib untuk menjalankan Laravel).
