# Deploy ke Hosting (cPanel)

## Setelah git pull

```bash
cd ~/repositories/websekolahku_v1
php composer.phar install --no-dev --no-scripts
php artisan migrate --force
bash deploy/setup-public-html.sh
php artisan optimize:clear
php artisan optimize
```

## Gambar tidak muncul?

1. Jalankan `bash deploy/setup-public-html.sh` (perbaiki symlink + restore backup).
2. Upload fallback Laravel sudah aktif di route `/storage/{path}` — file harus ada di `storage/app/public/`.
3. Jika folder `gallery/` kosong, restore dari backup atau upload ulang lewat Admin → Galeri.
