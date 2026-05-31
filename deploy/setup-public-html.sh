#!/bin/bash
# Setup public_html untuk Laravel di ~/repositories/websekolahku_v1
# Jalankan di Terminal cPanel: bash ~/repositories/websekolahku_v1/deploy/setup-public-html.sh

set -e

REPO="$HOME/repositories/websekolahku_v1"
WEB="$HOME/public_html"
UPLOADS="$REPO/storage/app/public"

echo "==> Laravel root: $REPO"
echo "==> Web root: $WEB"

cd "$REPO"
php artisan storage:link 2>/dev/null || true

cp "$REPO/deploy/public_html.htaccess" "$WEB/.htaccess"

cd "$WEB"

# css/js: copy (symlink sering gagal di shared hosting)
rm -rf "$WEB/css" "$WEB/js"
cp -a "$REPO/public/css" "$WEB/css"
cp -a "$REPO/public/js" "$WEB/js"
ln -sfn "../repositories/websekolahku_v1/public/robots.txt" robots.txt 2>/dev/null || cp -a "$REPO/public/robots.txt" "$WEB/robots.txt" 2>/dev/null || true

rm -rf "$WEB/images"
cp -a "$REPO/public/images" "$WEB/images"
if [ -d "$WEB/public/images" ]; then
    cp -an "$WEB/public/images/." "$WEB/images/" 2>/dev/null || cp -a "$WEB/public/images/." "$WEB/images/"
fi

# Hapus folder storage salah (bukan symlink), lalu buat symlink benar
if [ -L "$WEB/storage" ]; then
    rm -f "$WEB/storage"
elif [ -d "$WEB/storage" ]; then
    mv "$WEB/storage" "$WEB/storage_OLD_$(date +%Y%m%d_%H%M%S)"
fi
ln -sfn "../repositories/websekolahku_v1/storage/app/public" "$WEB/storage"

echo "==> Symlink & folder:"
ls -la css js images storage robots.txt 2>/dev/null || true

mkdir -p "$UPLOADS"

# Restore upload dari backup public_html
for BACKUP in "$HOME"/public_html_backup_*; do
    [ -d "$BACKUP" ] || continue

    if [ -d "$BACKUP/public/storage" ] && [ ! -L "$BACKUP/public/storage" ]; then
        echo "==> Copy upload: $BACKUP/public/storage"
        cp -an "$BACKUP/public/storage/." "$UPLOADS/" 2>/dev/null || cp -a "$BACKUP/public/storage/." "$UPLOADS/"
    fi

    if [ -d "$BACKUP/storage/gallery" ] || [ -d "$BACKUP/storage/hero-slides" ] || [ -d "$BACKUP/storage/settings" ]; then
        echo "==> Copy upload: $BACKUP/storage (folder upload)"
        cp -an "$BACKUP/storage/." "$UPLOADS/" 2>/dev/null || cp -a "$BACKUP/storage/." "$UPLOADS/"
    fi
done

chmod -R u+rwX,go+rX "$UPLOADS" 2>/dev/null || true
find "$UPLOADS" -type f -exec chmod 644 {} \; 2>/dev/null || true
mkdir -p "$UPLOADS/teachers"
chmod 775 "$UPLOADS/teachers" 2>/dev/null || true

echo ""
echo "==> Cek jumlah file upload:"
for folder in settings gallery hero-slides posts partners teachers; do
    count=$(ls "$UPLOADS/$folder" 2>/dev/null | wc -l | tr -d ' ')
    echo "    $folder: ${count:-0} file"
done

echo ""
echo "==> Cek asset statis (harus ada file):"
ls "$WEB/js/ppdb-wizard.js" "$WEB/css/app.css" "$WEB/images/spmb-banten-official.png" 2>&1 || echo "    PERINGATAN: ada asset yang belum tersalin!"
echo "Jalankan juga: cd $REPO && php artisan optimize:clear && php artisan optimize"
