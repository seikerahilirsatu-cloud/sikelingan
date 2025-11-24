# Kelurahan Satu Data (minimal) — kelurahanapp

Instruksi singkat untuk menjalankan migration dan seeder pada database lokal `dbkelurahan`.

1. Pastikan Anda memiliki project Laravel di folder ini atau gunakan composer untuk men-setup Laravel.

2. Untuk menjalankan migration dan seed (asumsi `php` dan `composer` tersedia):

```powershell
copy .env.example .env
# edit .env -> set DB_DATABASE=dbkelurahan, DB_USERNAME, DB_PASSWORD sesuai lingkungan
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Jika Anda hanya ingin mengimpor SQL, jalankan migration di atas atau gunakan file SQL yang sesuai.
