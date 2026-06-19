-- File ini digabung ke deploy/hosting-phpmyadmin-update.sql
-- Gunakan file gabungan itu untuk update lengkap di phpMyAdmin.
--
-- Jalankan di phpMyAdmin jika `php artisan migrate --force` tidak bisa di hosting.
-- Memperbarui kode & nama jurusan: AK, DKV, RPL, TITL, TSM (nama lengkap untuk laporan/cetak).

UPDATE `majors` SET `code` = 'AK', `name` = 'Akuntansi', `slug` = 'ak' WHERE `code` = 'AKL';
UPDATE `majors` SET `code` = 'TSM', `name` = 'Teknik Sepeda Motor', `slug` = 'tsm' WHERE `code` = 'TBSM';
UPDATE `majors` SET `name` = 'Disain Komunikasi Visual' WHERE `code` = 'DKV';
UPDATE `majors` SET `name` = 'Rekayasa Perangkat Lunak' WHERE `code` = 'RPL';
UPDATE `majors` SET `name` = 'Teknik Instalasi Tenaga Listrik' WHERE `code` = 'TITL';

-- Tandai migration sudah dijalankan (hindari error jika nanti pakai artisan migrate):
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_06_18_100000_update_major_codes_and_names', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_06_18_100000_update_major_codes_and_names'
);
