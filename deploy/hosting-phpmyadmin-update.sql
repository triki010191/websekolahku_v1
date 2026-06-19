-- =============================================================================
-- UPDATE DATABASE HOSTING — SMKN 8 Pandeglang (websekolahku_v1)
-- =============================================================================
-- Cara pakai (hosting TANPA terminal/SSH):
--   1. Login cPanel → phpMyAdmin
--   2. Pilih database website (contoh: user_smkn8)
--   3. Tab SQL → salin-tempel SEMUA perintah di bawah → Go / Jalankan
--
-- Aman dijalankan ulang: perintah hanya mengubah data/kolom yang perlu.
-- Setelah selesai: refresh halaman admin SPMB & formulir PPDB.
-- =============================================================================


-- -----------------------------------------------------------------------------
-- BAGIAN 1: Perbaiki kolom status pendaftaran PPDB
-- Menghindari error "Data truncated for column 'status'" saat status = valid
-- Mendukung status: pending, revisi, valid, accepted, rejected
-- -----------------------------------------------------------------------------

-- Ubah status lama "verified" menjadi "revisi" (jika masih ada)
UPDATE `ppdb_registrations`
SET `status` = 'revisi'
WHERE `status` = 'verified';

-- Ubah tipe kolom status ke VARCHAR (lebih aman di hosting)
ALTER TABLE `ppdb_registrations`
    MODIFY `status` VARCHAR(20) NOT NULL DEFAULT 'pending';


-- -----------------------------------------------------------------------------
-- BAGIAN 2: Update kode & nama jurusan
-- Dropdown formulir: kode singkat (AK, DKV, RPL, TITL, TSM)
-- Laporan / cetak PDF: nama lengkap
-- -----------------------------------------------------------------------------

UPDATE `majors` SET `code` = 'AK',  `name` = 'Akuntansi',                    `slug` = 'ak'  WHERE `code` = 'AKL';
UPDATE `majors` SET `code` = 'TSM', `name` = 'Teknik Sepeda Motor',          `slug` = 'tsm' WHERE `code` = 'TBSM';
UPDATE `majors` SET `name` = 'Disain Komunikasi Visual'                      WHERE `code` = 'DKV';
UPDATE `majors` SET `name` = 'Rekayasa Perangkat Lunak'                      WHERE `code` = 'RPL';
UPDATE `majors` SET `name` = 'Teknik Instalasi Tenaga Listrik'               WHERE `code` = 'TITL';

-- Jika jurusan sudah pakai kode baru (AK/TSM), pastikan nama tetap benar:
UPDATE `majors` SET `name` = 'Akuntansi',                    `slug` = 'ak'  WHERE `code` = 'AK';
UPDATE `majors` SET `name` = 'Teknik Sepeda Motor',          `slug` = 'tsm' WHERE `code` = 'TSM';


-- -----------------------------------------------------------------------------
-- BAGIAN 3: Tandai migration Laravel sudah dijalankan
-- (Opsional — agar tidak bentrok jika nanti ada akses artisan migrate)
-- -----------------------------------------------------------------------------

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_06_11_100000_add_revisi_status_to_ppdb_registrations', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_06_11_100000_add_revisi_status_to_ppdb_registrations'
);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_06_17_100000_add_valid_status_to_ppdb_registrations', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_06_17_100000_add_valid_status_to_ppdb_registrations'
);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_06_17_110000_convert_ppdb_status_column_to_varchar', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_06_17_110000_convert_ppdb_status_column_to_varchar'
);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_06_18_100000_update_major_codes_and_names', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`
WHERE NOT EXISTS (
    SELECT 1 FROM `migrations` WHERE `migration` = '2026_06_18_100000_update_major_codes_and_names'
);


-- -----------------------------------------------------------------------------
-- BAGIAN 4: Cek hasil (opsional — lihat di tab Hasil / Browse)
-- -----------------------------------------------------------------------------

SELECT `code`, `name`, `slug` FROM `majors` ORDER BY `sort_order`;

SELECT COLUMN_TYPE AS `tipe_kolom_status`
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = DATABASE()
  AND TABLE_NAME = 'ppdb_registrations'
  AND COLUMN_NAME = 'status';

-- Selesai. Jurusan seharusnya: AK, DKV, RPL, TITL, TSM dengan nama lengkap.
