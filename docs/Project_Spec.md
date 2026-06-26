# Project Specification: Bug Priority Analyzer

## Nama Project
**Bug Priority Analyzer**  
*Perbandingan Metode Fuzzy Mamdani, Sugeno, dan Tsukamoto untuk Menentukan Prioritas Bug Software*

---

## 1. Konsep Aplikasi & Fitur Utama

Aplikasi ini dirancang sebagai alat bantu penentuan prioritas bug perangkat lunak sekaligus media pembelajaran interaktif logika fuzzy. Pengguna dapat memahami bagaimana keputusan prioritas diambil melalui tiga metode fuzzy yang berbeda: Mamdani, Sugeno, dan Tsukamoto.

### Fitur Utama:
1. **Dashboard Statistik (Home)**
   - Hero section dengan desain teknologi modern (tema gelap/terang, dominan hitam, biru, dan cyan).
   - Penjelasan singkat tentang Logika Fuzzy dan diagram alur sistem (Fuzzifikasi → Inferensi → Defuzzifikasi).
   - Ringkasan statistik penggunaan: Total simulasi, rata-rata skor prioritas dari ketiga metode.
2. **Materi Pembelajaran Fuzzy**
   - Halaman edukasi yang menjelaskan konsep dasar fuzzy, serta detail teknis ketiga metode (Mamdani, Sugeno, Tsukamoto).
   - Tabel perbandingan kelebihan, kekurangan, dan karakteristik masing-masing metode.
3. **Simulasi Perhitungan**
   - Input interaktif menggunakan slider modern untuk tiga variabel: **Severity**, **Impact**, dan **Affected Users** (skala 0 - 100).
   - Kalkulasi real-time yang memisahkan logika ke Service Layer (`app/Services`).
   - Tampilan langkah demi langkah (step-by-step breakdown) proses fuzzifikasi (nilai keanggotaan) dan visualisasi aturan yang aktif.
4. **Perbandingan Metode**
   - Halaman khusus untuk membandingkan hasil output ketiga metode secara langsung dari input yang sama.
   - Dilengkapi visualisasi grafik batang (bar chart) interaktif.
5. **Riwayat Simulasi (History)**
   - Tabel riwayat yang menampilkan seluruh data simulasi yang disimpan di database.
   - Fitur pencarian/filter sederhana dan hapus riwayat.

---

## 2. Model Matematika Fuzzy

### A. Variabel Input (Semesta Pembicaraan: 0 - 100)
1. **Severity ($S$)** - Tingkat keparahan bug secara teknis:
   - **Low**: Trapesium $[0, 0, 20, 40]$
   - **Medium**: Segitiga $[20, 50, 80]$
   - **High**: Trapesium $[60, 80, 100, 100]$

2. **Impact ($I$)** - Dampak bug terhadap bisnis/operasional:
   - **Minor**: Trapesium $[0, 0, 25, 45]$
   - **Moderate**: Segitiga $[25, 50, 75]$
   - **Major**: Trapesium $[55, 75, 100, 100]$

3. **Affected Users ($U$)** - Persentase pengguna yang terdampak:
   - **Few**: Trapesium $[0, 0, 30, 50]$
   - **Many**: Segitiga $[30, 60, 90]$
   - **Critical**: Trapesium $[70, 90, 100, 100]$

### B. Variabel Output (Priority Score: 0 - 100)
- **Low**: Nilai Prioritas Rendah
- **Medium**: Nilai Prioritas Sedang
- **High**: Nilai Prioritas Tinggi
- **Critical**: Nilai Prioritas Kritis

### C. Basis Aturan (27 Rules)
Inferensi menggunakan fungsi **MIN** untuk relasi AND.
1. IF $S$ is Low AND $I$ is Minor AND $U$ is Few THEN Priority is **Low**
2. IF $S$ is Low AND $I$ is Minor AND $U$ is Many THEN Priority is **Low**
3. IF $S$ is Low AND $I$ is Minor AND $U$ is Critical THEN Priority is **Medium**
4. IF $S$ is Low AND $I$ is Moderate AND $U$ is Few THEN Priority is **Low**
5. IF $S$ is Low AND $I$ is Moderate AND $U$ is Many THEN Priority is **Medium**
6. IF $S$ is Low AND $I$ is Moderate AND $U$ is Critical THEN Priority is **Medium**
7. IF $S$ is Low AND $I$ is Major AND $U$ is Few THEN Priority is **Medium**
8. IF $S$ is Low AND $I$ is Major AND $U$ is Many THEN Priority is **Medium**
9. IF $S$ is Low AND $I$ is Major AND $U$ is Critical THEN Priority is **High**
10. IF $S$ is Medium AND $I$ is Minor AND $U$ is Few THEN Priority is **Low**
11. IF $S$ is Medium AND $I$ is Minor AND $U$ is Many THEN Priority is **Medium**
12. IF $S$ is Medium AND $I$ is Minor AND $U$ is Critical THEN Priority is **High**
13. IF $S$ is Medium AND $I$ is Moderate AND $U$ is Few THEN Priority is **Medium**
14. IF $S$ is Medium AND $I$ is Moderate AND $U$ is Many THEN Priority is **Medium**
15. IF $S$ is Medium AND $I$ is Moderate AND $U$ is Critical THEN Priority is **High**
16. IF $S$ is Medium AND $I$ is Major AND $U$ is Few THEN Priority is **Medium**
17. IF $S$ is Medium AND $I$ is Major AND $U$ is Many THEN Priority is **High**
18. IF $S$ is Medium AND $I$ is Major AND $U$ is Critical THEN Priority is **Critical**
19. IF $S$ is High AND $I$ is Minor AND $U$ is Few THEN Priority is **Medium**
20. IF $S$ is High AND $I$ is Minor AND $U$ is Many THEN Priority is **High**
21. IF $S$ is High AND $I$ is Minor AND $U$ is Critical THEN Priority is **High**
22. IF $S$ is High AND $I$ is Moderate AND $U$ is Few THEN Priority is **Medium**
23. IF $S$ is High AND $I$ is Moderate AND $U$ is Many THEN Priority is **High**
24. IF $S$ is High AND $I$ is Moderate AND $U$ is Critical THEN Priority is **Critical**
25. IF $S$ is High AND $I$ is Major AND $U$ is Few THEN Priority is **High**
26. IF $S$ is High AND $I$ is Major AND $U$ is Many THEN Priority is **Critical**
27. IF $S$ is High AND $I$ is Major AND $U$ is Critical THEN Priority is **Critical**

### D. Perbedaan Defuzzifikasi Metode
1. **Mamdani (Centroid)**:
   Menggunakan metode luas daerah (centroid) dengan membagi area output menjadi beberapa grid sampel (0-100, step 1), melakukan komposisi aturan menggunakan operator MAX pada fungsi keanggotaan output, kemudian menghitung:
   $$P^* = \frac{\sum (y \cdot \mu_{\text{agg}}(y))}{\sum \mu_{\text{agg}}(y)}$$
2. **Sugeno (Rata-rata Terbobot - Orde Nol)**:
   Menggunakan nilai konstan (singleton) untuk tiap konsekuen:
   - Low = 25
   - Medium = 50
   - High = 75
   - Critical = 100
   $$P^* = \frac{\sum (\alpha_k \cdot z_k)}{\sum \alpha_k}$$
3. **Tsukamoto**:
   Setiap aturan memberikan output $z_k$ berdasarkan fungsi keanggotaan monotonik konsekuen:
   - **Low** (Monoton Turun $[0, 40]$): $z_k = 40 - (\alpha_k \cdot 40)$
   - **Medium** (Monoton Naik $[20, 60]$): $z_k = 20 + (\alpha_k \cdot 40)$
   - **High** (Monoton Naik $[50, 85]$): $z_k = 50 + (\alpha_k \cdot 35)$
   - **Critical** (Monoton Naik $[75, 100]$): $z_k = 75 + (\alpha_k \cdot 25)$
   $$P^* = \frac{\sum (\alpha_k \cdot z_k)}{\sum \alpha_k}$$

---

## 3. Desain UI/UX & Warna
Desain bertema **Modern Technology Dashboard** (mirip GitHub/Vercel/Linear) dengan dark mode default dan opsi toggle light mode.

- **Background**: `#0F172A` (Slate 900)
- **Card Background**: `#111827` (Gray 900)
- **Primary Blue**: `#2563EB` (Blue 600)
- **Secondary Blue**: `#3B82F6` (Blue 500)
- **Accent Cyan**: `#06B6D4` (Cyan 500)
- **Text**: `#F8FAFC` (Slate 50)
- **Border**: `#334155` (Slate 700)

---

## 4. Struktur Folder Project

```text
app/
├── Models/
│   └── Bug.php
├── Services/
│   ├── FuzzyMamdaniService.php
│   ├── FuzzySugenoService.php
│   └── FuzzyTsukamotoService.php
├── Http/
│   └── Controllers/
│       ├── HomeController.php
│       ├── SimulasiController.php
│       ├── HistoryController.php
│       └── MateriController.php

resources/
└── views/
    ├── layouts/
    │   ├── app.blade.php
    │   ├── navbar.blade.php
    │   └── footer.blade.php
    ├── home.blade.php
    ├── materi.blade.php
    ├── simulasi.blade.php
    ├── perbandingan.blade.php
    └── history.blade.php
```

---

## 5. Skema Database (Tabel `bugs`)
- `id` (Primary Key, Auto Increment)
- `severity` (Integer, 0-100)
- `impact` (Integer, 0-100)
- `affected_users` (Integer, 0-100)
- `mamdani_score` (Double)
- `mamdani_label` (String, e.g. "Low", "Medium", "High", "Critical")
- `sugeno_score` (Double)
- `sugeno_label` (String)
- `tsukamoto_score` (Double)
- `tsukamoto_label` (String)
- `created_at` & `updated_at` (Timestamps)

---

## 6. Roadmap Pengerjaan
1. **Tahap 0: Analisis & Spesifikasi** (Selesai - Dokumen ini dibuat)
2. **Tahap 1: Setup Project Laravel & Tailwind CSS**
   - Inisialisasi project Laravel.
   - Konfigurasi database SQLite (default, ringan, tanpa setup server rumit).
   - Setup Tailwind CSS dan konfigurasi tema warna utama.
3. **Tahap 2: Implementasi Database & Model**
   - Buat file migration untuk tabel `bugs`.
   - Buat model `Bug.php`.
4. **Tahap 3: Implementasi Service Layer (Logika Fuzzy)**
   - Buat `FuzzyMamdaniService.php` beserta fungsi centroid.
   - Buat `FuzzySugenoService.php` beserta weighted average singleton.
   - Buat `FuzzyTsukamotoService.php` beserta fungsi keanggotaan monotonik.
5. **Tahap 4: Pembuatan Controller & Routing**
   - Buat `HomeController`, `SimulasiController`, `HistoryController`, `MateriController`.
   - Definisikan web routes di `routes/web.php`.
6. **Tahap 5: Pembuatan UI & Layouts (Blade)**
   - Implementasikan layout `app.blade.php`, `navbar`, dan `footer`.
   - Bangun halaman Home dengan dashboard statistik & grafik.
   - Bangun halaman Materi dengan visualisasi teori fuzzy.
   - Bangun halaman Simulasi dengan slider input dan step-by-step breakdown.
   - Bangun halaman Perbandingan dengan chart.
   - Bangun halaman History dengan tabel data simulasi.
7. **Tahap 6: Pengujian, Validasi & Finetuning**
   - Uji perhitungan matematika fuzzy dengan beberapa test case.
   - Pastikan toggle Dark/Light mode berjalan lancar di seluruh halaman.
   - Poles transisi/animasi mikro.
