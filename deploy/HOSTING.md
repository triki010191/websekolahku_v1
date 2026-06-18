# Deploy ke Hosting (cPanel)

## Folder mana yang dipakai Laravel?

Di banyak hosting, **document root** = `~/public_html`, tetapi kode Laravel jalan dari **`~/repositories/websekolahku_v1`**.

Cek isi `~/public_html/index.php` — jika ada path `repositories/websekolahku_v1`, maka perintah `php artisan` **wajib** dijalankan di folder repository, bukan di `public_html`.

```bash
# Cek Laravel root dari index.php
head -25 ~/public_html/index.php
```

## Setup database pertama kali (hosting baru)

1. **cPanel → MySQL Databases** — buat database, user, dan beri **All Privileges**.
2. **Import skema** (jika database masih kosong):
   - phpMyAdmin → pilih database → Import → file `database/schema_mysql.sql`
   - Atau lewat SSH: `mysql -u USER -p NAMA_DB < database/schema_mysql.sql`
3. **Salin `.env` di server** dari template `deploy/env.hosting.example`:
   ```bash
   cd ~/repositories/websekolahku_v1
   cp deploy/env.hosting.example .env
   nano .env   # isi DB_DATABASE, DB_USERNAME, DB_PASSWORD, APP_URL, APP_KEY
   php artisan key:generate
   ```
4. **Jalankan migration & seed** (data awal admin, jurusan, pengaturan):
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```
5. **Login admin default** (ubah password setelah login): lihat `database/seeders/UserSeeder.php`.

### Variabel `.env` database (wajib di hosting)

| Variabel | Contoh cPanel | Keterangan |
|----------|---------------|------------|
| `DB_HOST` | `localhost` | Biasanya `localhost`, bukan IP |
| `DB_DATABASE` | `user_smkn8` | Nama database lengkap dari cPanel |
| `DB_USERNAME` | `user_smkn8` | User MySQL dari cPanel |
| `DB_PASSWORD` | `***` | Password user MySQL |

Produksi: `APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://domain-anda.sch.id`.

## Setelah git pull

```bash
cd ~/repositories/websekolahku_v1
git pull origin main
php composer.phar install --no-dev --no-scripts
php artisan migrate --force
bash deploy/setup-public-html.sh
php artisan optimize:clear
php artisan optimize
```

Jika repo Anda memang di `public_html` (full Laravel di situ), ganti `cd` ke `~/public_html`.

## Halaman SPMB 404 (mis. `/spmb-2026/panduan-dapodik`)

Biasanya **route cache lama** di folder Laravel root yang salah.

```bash
cd ~/repositories/websekolahku_v1   # sesuaikan dengan Laravel root Anda
grep panduan-dapodik routes/web.php
php artisan route:list | grep spmb
rm -f bootstrap/cache/routes-v7.php
php artisan route:clear
php artisan optimize:clear
```

Ulangi perintah yang sama di `~/public_html` jika di sana juga ada instalasi Laravel.

## Error status `valid` / cetak Kartu TES gagal

Pesan: `Data truncated for column 'status'` saat mengubah status ke **Data Sudah Valid**.

Penyebab: migration database belum dijalankan setelah `git pull`.

**Opsi A — lewat SSH (disarankan):**

```bash
cd ~/repositories/websekolahku_v1   # sesuaikan Laravel root
php artisan migrate --force
php artisan optimize:clear
```

**Opsi B — lewat phpMyAdmin** (jika tidak ada SSH):

Jalankan SQL dari file `deploy/fix-ppdb-valid-status.sql`:

```sql
ALTER TABLE `ppdb_registrations`
    MODIFY `status` VARCHAR(20) NOT NULL DEFAULT 'pending';
```

Setelah itu, ubah status pendaftar ke **Data Sudah Valid** lalu cetak Bukti Validasi lagi.

## Update kode jurusan (AK, DKV, RPL, TITL, TSM)

Setelah `git pull` versi terbaru, jalankan migration jurusan:

**Opsi A — lewat SSH (disarankan):**

```bash
cd ~/repositories/websekolahku_v1
php artisan migrate --force
php artisan optimize:clear
```

**Opsi B — lewat phpMyAdmin** (jika tidak ada SSH):

Jalankan SQL dari file `deploy/update-major-codes.sql`.

Dropdown formulir PPDB menampilkan kode singkat; laporan/cetak PDF memakai nama lengkap jurusan.

## Gambar tidak muncul?

1. Jalankan `bash deploy/setup-public-html.sh` (perbaiki symlink + restore backup).
2. Upload fallback Laravel sudah aktif di route `/storage/{path}` — file harus ada di `storage/app/public/`.
3. Jika folder `gallery/` kosong, restore dari backup atau upload ulang lewat Admin → Galeri.
