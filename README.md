# LaptopLoan

Aplikasi Laravel untuk pengelolaan inventaris dan peminjaman laptop sekolah.

## Persyaratan

- PHP 8.2 atau lebih baru dengan ekstensi Laravel yang dibutuhkan
- Composer
- Node.js dan npm
- MySQL dari XAMPP, atau SQLite

## Menjalankan di XAMPP

1. Letakkan proyek di `C:\xampp\htdocs\mang-polder` dan buat database `mang_polder` melalui phpMyAdmin.
2. Salin `.env.example` menjadi `.env`, lalu sesuaikan konfigurasi database:

   ```dotenv
   APP_URL=http://localhost/mang-polder/public
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=mang_polder
   DB_USERNAME=root
   DB_PASSWORD=
   ```

   Jika folder atau alamat aplikasi berbeda, isi `APP_URL` dengan alamat yang benar-benar dipakai di browser. Nilai ini dipakai Laravel untuk URL aset, manifest, dan service worker PWA. Jika Apache diarahkan langsung ke folder `public` melalui VirtualHost, gunakan URL VirtualHost tersebut, misalnya `http://mang-polder.test`.

3. Tentukan identitas dan sandi admin sebelum seeding. Nilai bawaan hanya untuk instalasi lokal:

   ```dotenv
   ADMIN_NAME="Admin Sekolah"
   ADMIN_EMAIL=admin@sekolah.com
   ADMIN_PASSWORD=admin123
   ```

   Ganti `ADMIN_PASSWORD` dengan sandi yang kuat sebelum membuat akun. Seeder memastikan akun tersebut ber-role admin dan aktif, tetapi tidak mengatur ulang sandi saat dijalankan ulang.

4. Pasang dependensi, buat kunci aplikasi, lalu jalankan migrasi dan seeder:

   ```powershell
   composer install
   npm install
   php artisan key:generate
   php artisan config:clear
   php artisan migrate --seed
   npm run build
   ```

5. Buka `http://localhost/mang-polder/public`. Pastikan Apache mengaktifkan `mod_rewrite` agar rute Laravel dapat digunakan.

Untuk pengembangan tanpa Apache, atur `APP_URL=http://127.0.0.1:8000`, lalu jalankan:

```powershell
php artisan serve
```

Buka `http://127.0.0.1:8000`. Konteks aman seperti `localhost` diperlukan browser untuk mengaktifkan service worker; situs yang dipasang selain localhost perlu HTTPS.

## Deploy ke Vercel

Proyek ini memakai Laravel dan memerlukan PHP, jadi deploy sebagai container (bukan static site/Vite). Pastikan Root Directory Vercel menunjuk ke root repository dan gunakan konfigurasi `vercel.json` yang tersedia. Vercel membangun `Dockerfile` dengan FrankenPHP; Node.js membangun aset Vite di dalam image.

Atur environment variables berikut di Vercel sebelum deploy:

- `APP_KEY`: buat sekali dengan `php artisan key:generate --show`, lalu simpan nilainya di Vercel (jangan commit ke Git).
- `APP_URL`: URL deployment Vercel.
- `DB_CONNECTION=mysql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`: koneksi ke database MySQL yang dapat diakses dari Vercel.
- Untuk Aiven MySQL, image memuat CA publik di `certs/aiven-ca.pem` dan menetapkan `MYSQL_ATTR_SSL_CA=/app/certs/aiven-ca.pem` untuk verifikasi TLS. Jangan mengganti file CA itu dengan kredensial database.

Database SQLite lokal tidak disertakan dalam image. Jalankan migrasi pada database production satu kali melalui proses release/CI setelah environment database tersedia:

```powershell
php artisan migrate --force
```

Container menyimpan session di database MySQL, memakai cache sementara dan queue sinkron. File upload tidak persisten di filesystem container; gunakan object storage untuk data yang harus bertahan.

## Database

Gunakan migrasi berikut untuk membuat atau memperbarui skema:

```powershell
php artisan migrate
```

Untuk mengisi atau menyegarkan data admin:

```powershell
php artisan db:seed
```

Seeder tidak membuat akun pengguna uji. Untuk mengulang semua migrasi sekaligus dan menghapus seluruh data lokal, gunakan `php artisan migrate:fresh --seed` hanya pada database pengembangan yang memang boleh dikosongkan.

## Email SMTP

Pengiriman email memakai konfigurasi Laravel. Atur nilai berikut pada `.env` sesuai penyedia email; jangan masukkan kredensial SMTP ke repository:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=akun-smtp
MAIL_PASSWORD=sandi-aplikasi
MAIL_SCHEME=smtp
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="LaptopLoan"
```

Gunakan host, port, skema, dan kredensial yang diberikan penyedia email. Setelah mengubah konfigurasi, jalankan `php artisan config:clear`.

## Pengujian dan build

```powershell
php artisan test
npm run build
```# laptoploan
\r\n