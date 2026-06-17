# Deploy ke Hosting (cPanel)

## Folder mana yang dipakai Laravel?

Di banyak hosting, **document root** = `~/public_html`, tetapi kode Laravel jalan dari **`~/repositories/websekolahku_v1`**.

Cek isi `~/public_html/index.php` — jika ada path `repositories/websekolahku_v1`, maka perintah `php artisan` **wajib** dijalankan di folder repository, bukan di `public_html`.

```bash
# Cek Laravel root dari index.php
head -25 ~/public_html/index.php
```

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

Setelah itu, ubah status pendaftar ke **Data Sudah Valid** lalu cetak Kartu TES lagi.

## Gambar tidak muncul?

1. Jalankan `bash deploy/setup-public-html.sh` (perbaiki symlink + restore backup).
2. Upload fallback Laravel sudah aktif di route `/storage/{path}` — file harus ada di `storage/app/public/`.
3. Jika folder `gallery/` kosong, restore dari backup atau upload ulang lewat Admin → Galeri.
