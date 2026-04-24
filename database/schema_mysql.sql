-- MySQL: buat database untuk website SMKN 8 Pandeglang (Laravel)
-- Jalankan sebagai user yang punya privilege CREATE, contoh: mysql -u root -p < database/schema_mysql.sql

CREATE DATABASE IF NOT EXISTS `smkn8_pandeglang`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

-- Opsional: user khusus aplikasi
-- CREATE USER 'smkn8'@'localhost' IDENTIFIED BY 'ganti_password_di_sini';
-- GRANT ALL PRIVILEGES ON `smkn8_pandeglang`.* TO 'smkn8'@'localhost';
-- FLUSH PRIVILEGES;

-- Setelah database ada, di folder laravel-app jalankan:
--   cp .env.example .env
--   (edit .env: DB_CONNECTION=mysql, DB_DATABASE=smkn8_pandeglang, DB_USERNAME, DB_PASSWORD)
--   php artisan key:generate
--   php artisan migrate --seed
--   php artisan storage:link
