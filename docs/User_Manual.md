# Panduan Penggunaan Aplikasi (User Manual)

Aplikasi **Bug Priority Analyzer** didesain dengan UI modern berbasis TailwindCSS agar mudah digunakan secara intuitif oleh dosen atau penguji saat demo. Berikut adalah panduan fungsionalitas fiturnya.

## 1. Beranda (Home)
Halaman penyambutan (*landing page*) yang memberikan ringkasan fitur aplikasi dan konteks proyek. 

## 2. Materi Fuzzy
Dokumentasi statis yang berisi landasan teori kecerdasan buatan, menjelaskan apa itu fuzzifikasi, fungsi keanggotaan, inferensi, serta penjelasan masing-masing metode (Mamdani, Sugeno, Tsukamoto) sebagai dasar edukasi pengguna.

## 3. Halaman Simulasi
Halaman inti tempat pengguna melakukan tes data:
1. **Form Input:** Di sebelah kiri, Anda dapat menggeser *slider* atau mengetikkan angka (0-100) untuk `Severity`, `Impact`, dan `Users`.
2. **Contoh Data Cepat:** Terdapat tombol *shortcut* (Ringan, Sedang, Berat, Critical) yang jika diklik akan otomatis menganimasikan angka di *slider* ke nilai bawaan (*default dummy data*).
3. **Hasil Kalkulasi:** Setelah klik "Hitung Prioritas", layar kanan akan menampilkan:
   - *Timeline* proses sistem berpikir.
   - *Rule* fuzzy dengan kontribusi terbesar (*firing strength* α terbesar).
   - *Card* hasil untuk 3 metode yang berbeda, yang memuat Skor *Crisp*, Status Prioritas, dan Rekomendasi Tindakan dalam bentuk modern *alert*.

## 4. Halaman Perbandingan Metode
Halaman ini fokus untuk analisa analitik. Pengguna dapat me-request angka tertentu, kemudian sistem akan menyajikan hasil Mamdani, Sugeno, dan Tsukamoto dalam satu tabel komparasi yang berjejer (*side-by-side*). Hal ini mempermudah peneliti membandingkan kelemahan/kelebihan tiap perhitungan *defuzzifikasi*.

## 5. Riwayat (History)
Setiap tes yang berhasil dilakukan di menu Simulasi dan Perbandingan secara otomatis disimpan di database lokal SQLite.
- Anda dapat meninjau ulang riwayat tes di tabel *History*.
- Terdapat tombol tempat sampah merah untuk menghapus rekaman riwayat secara permanen.

## Fitur Ekstra: Tema Gelap (Dark Mode)
Aplikasi mendukung mode gelap. Di bagian ujung kanan *navbar* atas, terdapat tombol *toggle* berbentuk ikon Bulan/Matahari. Klik tombol tersebut untuk mengubah pencahayaan antarmuka sistem secara keseluruhan.
