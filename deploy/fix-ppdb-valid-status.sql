-- Jalankan di phpMyAdmin jika `php artisan migrate --force` tidak bisa di hosting.
-- Memperbaiki error: Data truncated for column 'status' saat status = valid

ALTER TABLE `ppdb_registrations`
    MODIFY `status` VARCHAR(20) NOT NULL DEFAULT 'pending';
