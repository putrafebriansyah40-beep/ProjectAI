# Panduan Instalasi dan Menjalankan Proyek (Setup Guide)

Dokumen ini menjelaskan langkah-langkah untuk menjalankan aplikasi **Bug Priority Analyzer** di lingkungan lokal Anda.

## Prasyarat
- PHP >= 8.1
- Composer
- Node.js & npm
- SQLite / MySQL (Secara default menggunakan SQLite di dalam folder database)

## Langkah Instalasi

1. **Clone atau Ekstrak Repository**
   Pastikan Anda telah mengekstrak file project atau berada di direktori proyek di terminal.

2. **Install Dependensi PHP**
   Jalankan composer untuk mengunduh semua library backend Laravel.
   ```bash
   composer install
   ```

3. **Install Dependensi Frontend**
   Jalankan npm untuk mengunduh library CSS/JS seperti Tailwind.
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Jika file `.env` belum ada, salin file `.env.example` menjadi `.env`.
   ```bash
   cp .env.example .env
   ```
   Lalu *generate application key*:
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database**
   Jalankan perintah berikut untuk membuat tabel `bugs` (tempat menyimpan riwayat simulasi):
   ```bash
   php artisan migrate
   ```

6. **Menjalankan Server (Penting!)**
   Karena project ini menggunakan *Vite* sebagai *asset bundler*, Anda membutuhkan **2 terminal** yang berjalan secara bersamaan:
   
   **Terminal 1** (Menjalankan server web lokal PHP):
   ```bash
   php artisan serve
   ```
   
   **Terminal 2** (Melakukan *compile* dan *hot-reload* untuk Tailwind CSS dan JavaScript):
   ```bash
   npm run dev
   ```

7. **Akses Aplikasi**
   Setelah kedua terminal berjalan, buka browser dan akses URL: `http://127.0.0.1:8000`.
