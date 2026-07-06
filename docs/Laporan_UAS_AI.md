# Laporan Tugas Akhir Mata Kuliah Kecerdasan Buatan (AI)
**Judul Proyek:** Sistem Pendukung Keputusan Penentuan Prioritas Bug Menggunakan Logika Fuzzy (Mamdani, Sugeno, Tsukamoto)
**Mata Kuliah:** Kecerdasan Buatan (Artificial Intelligence)
**Program Studi:** Teknologi Rekayasa Perangkat Lunak (TRPL)

---

## BAB I: Pendahuluan

### 1.1 Latar Belakang
Dalam siklus pengembangan perangkat lunak (Software Development Life Cycle/SDLC), proses manajemen dan perbaikan *bug* merupakan hal yang sangat krusial. Seringkali, tim *Quality Assurance* (QA) dan *Developer* berhadapan dengan puluhan hingga ratusan *bug* secara bersamaan. Menentukan *bug* mana yang harus diperbaiki terlebih dahulu (*Bug Triage*) seringkali memunculkan perdebatan karena penilaian manusia cenderung subjektif, bias, dan terperangkap dalam "area abu-abu" (ambigu).

Misalnya, sebuah *bug* mungkin sangat parah secara teknis, namun hanya berdampak pada sedikit pengguna. Apakah ini lebih penting dari *bug* kecil yang berdampak pada seluruh pengguna? 

Logika Fuzzy (*Fuzzy Logic*) sangat ideal untuk menangani ketidakpastian dan ambiguitas semacam ini karena logika ini merepresentasikan kebenaran sebagian (*partial truth*), bukan sekadar nilai biner *True* atau *False*. Oleh karena itu, dibangunlah aplikasi "Bug Priority Analyzer" untuk mengotomatisasi penentuan prioritas *bug* secara matematis.

### 1.2 Tujuan Proyek
1. Menerapkan teori Kecerdasan Buatan, khususnya sistem inferensi Fuzzy, ke dalam studi kasus nyata di bidang rekayasa perangkat lunak.
2. Membangun sebuah antarmuka web interaktif yang dapat memproses parameter teknis *bug* menjadi tingkat prioritas yang pasti.
3. Melakukan komparasi komprehensif (head-to-head) antara 3 metode Fuzzy: Mamdani, Sugeno, dan Tsukamoto dalam satu sistem yang sama.

---

## BAB II: Landasan Teori (Kecerdasan Buatan)

### 2.1 Pengantar Logika Fuzzy
Logika Fuzzy pertama kali diperkenalkan oleh Prof. Lotfi A. Zadeh pada tahun 1965. Berbeda dengan logika tegas (Crisp Logic / Boolean) yang hanya mengenal nilai 0 (Salah) dan 1 (Benar), logika fuzzy memungkinkan nilai keanggotaan berada di antara 0 dan 1. Hal ini memungkinkan sistem komputer untuk berpikir lebih mirip dengan bahasa dan nalar manusia (contoh: "sedikit parah", "lumayan berdampak").

### 2.2 Tahapan Sistem Fuzzy
Sistem inferensi fuzzy (Fuzzy Inference System/FIS) secara umum bekerja melalui 3 tahap utama:
1. **Fuzzifikasi:** Mengubah masukan nilai pasti (*crisp input*) menjadi nilai linguistik fuzzy menggunakan fungsi keanggotaan.
2. **Evaluasi Aturan (Inferensi):** Memasukkan derajat keanggotaan fuzzy ke dalam basis aturan (Rule Base IF-THEN) untuk menghasilkan keluaran fuzzy.
3. **Defuzzifikasi:** Mengubah kembali keluaran fuzzy hasil inferensi menjadi nilai pasti (*crisp output*) yang dapat digunakan sebagai keputusan akhir.

### 2.3 Komparasi 3 Metode Fuzzy
Dalam proyek ini, digunakan 3 metode FIS yang paling populer:
1. **Metode Mamdani (Max-Min):** Diperkenalkan oleh Ebrahim Mamdani (1975). Metode ini paling menyerupai nalar manusia. Bagian konsekuen (THEN) berupa himpunan fuzzy. Menggunakan metode *Centroid* (titik berat luasan) untuk defuzzifikasi.
2. **Metode Sugeno (Orde Nol):** Diperkenalkan oleh Takagi-Sugeno-Kang (1985). Bagian konsekuen (THEN) bukanlah himpunan fuzzy, melainkan sebuah persamaan matematika linear (konstanta tunggal untuk Orde Nol). Defuzzifikasi menggunakan perhitungan Rata-rata Terbobot (*Weighted Average*). Keunggulannya adalah komputasi yang lebih cepat.
3. **Metode Tsukamoto:** Bagian konsekuen (THEN) dari setiap aturan harus berupa himpunan fuzzy yang monoton (kurva Z atau S). Hasil akhir dihitung menggunakan Rata-rata Terbobot (*Weighted Average*) berdasarkan nilai *alpha-cut* (derajat kebenaran) dari setiap aturan.

---

## BAB III: Perancangan Sistem & Logika

### 3.1 Variabel Input & Fungsi Keanggotaan
Sistem dirancang menerima 3 nilai variabel dari rentang 0 hingga 100.
1. **Severity:** Tingkat keparahan secara teknis.
2. **Impact:** Dampak kerugian operasional dan bisnis.
3. **Affected Users:** Persentase pengguna yang terdampak.

Ketiga variabel tersebut dibagi menjadi 3 himpunan linguistik:
- **Rendah (Low):** 0 - 40
- **Sedang (Medium):** 30 - 70
- **Tinggi (High):** 60 - 100

Sistem menggunakan gabungan bentuk **Kurva Trapesium** (untuk himpunan Rendah dan Tinggi di sisi batas) serta **Kurva Segitiga** (untuk himpunan Sedang di tengah).

### 3.2 Variabel Output (Priority Level)
Hasil keluaran dari sistem (*Crisp Output*) berupa angka 0 hingga 100, yang kemudian dipetakan ke dalam 4 kategori status penanganan:
- **Low (0 - 25):** Bug minor, ditunda jika ada tugas lain.
- **Medium (26 - 50):** Dimasukkan ke dalam antrean *sprint* berikutnya.
- **High (51 - 75):** Masalah besar, selesaikan di *sprint* saat ini.
- **Critical (76 - 100):** Darurat utama, perbaiki segera (*hotfix*).

### 3.3 Basis Aturan (Rule Base)
Dikarenakan terdapat 3 Variabel Input yang masing-masing memiliki 3 Himpunan, maka total kemungkinan aturan adalah 3 × 3 × 3 = **27 Aturan (*Rules*)**.
Contoh:
- `[R1] IF Severity=Tinggi AND Impact=Tinggi AND Users=Tinggi THEN Priority=Critical`
- `[R14] IF Severity=Sedang AND Impact=Sedang AND Users=Sedang THEN Priority=Medium`
- `[R27] IF Severity=Rendah AND Impact=Rendah AND Users=Rendah THEN Priority=Low`

---

## BAB IV: Implementasi dan Analisis Hasil

### 4.1 Arsitektur Perangkat Lunak
Sistem dibangun menggunakan *framework* **Laravel (PHP)** dan dikemas dengan antarmuka **TailwindCSS**. 
Arsitektur menerapkan prinsip *Clean Code*:
- **Controller:** Mengatur perpindahan rute dan penerimaan form.
- **Services:** Logika matematika murni (Mamdani, Sugeno, Tsukamoto) dipisahkan ke dalam *folder* `app/Services` yang independen sehingga algoritma sangat *maintainable*.
- **Views:** Menggunakan komponen blade interaktif.
- **Database:** SQLite untuk menyimpan Riwayat (History).

### 4.2 Analisis Perbandingan (Studi Kasus)
Mari asumsikan pengguna menginput nilai berikut:
- **Severity** = 65 (Masuk area irisan Sedang & Tinggi)
- **Impact** = 70 (Masuk area batas atas Sedang)
- **Users** = 71 (Masuk area Tinggi)

**Hasil Output Sistem:**
- **Mamdani:** Menghasilkan skor 68.4 (Kategori: HIGH)
- **Sugeno:** Menghasilkan skor 81.5 (Kategori: CRITICAL)
- **Tsukamoto:** Menghasilkan skor 63.0 (Kategori: HIGH)

**Analisa Hasil Mengapa Bisa Berbeda:**
1. **Mamdani** menghasilkan nilai tengah-tengah (68.4) karena ia menghitung titik potong (luasan area trapesium) secara keseluruhan, sehingga nilai-nilai yang ekstrem akan saling menetralisir atau merata ke tengah (*center of gravity*).
2. **Sugeno** menghasilkan skor sangat ekstrem (81.5) karena pada Orde-Nol, keluaran hanya direpresentasikan oleh nilai tunggal/konstan dari aturan terkuat (*Critical* = 100, *High* = 75). Rumus rata-rata terbobot (*Weighted Average*) pada nilai konstan cenderung menarik rata-rata lebih kuat ke arah batas atas/bawah.
3. **Tsukamoto** mendapatkan nilai (63.0) karena sifatnya yang linier monoton (menggunakan kurva menurun dan menanjak). Tsukamoto bertumpu pada batas-batas *alpha-predicate* linier, menjadikannya metode yang paling sensitif terhadap perubahan kecil di batas tengah, namun terkadang menghasilkan nilai *crisp* yang paling konservatif di antara metode lainnya.

---

## BAB V: Penutup

### 5.1 Kesimpulan
Penerapan Logika Fuzzy terbukti sangat relevan dan andal untuk mengatasi masalah *Bug Triage* pada proyek perangkat lunak. 
1. Logika Fuzzy mampu memproses ambiguitas (seperti tingkat keparahan yang bersifat subjektif) menjadi skor keputusan matematis yang dapat dipertanggungjawabkan.
2. Ketiga metode Fuzzy (Mamdani, Sugeno, Tsukamoto) mampu diimplementasikan dalam satu arsitektur terpadu. Perbedaan skor defuzzifikasi dari ketiga metode tersebut wajar terjadi karena setiap metode memiliki cara agregasi (luas area vs konstan vs linier) yang berbeda.
3. Secara praktis, **Mamdani** cocok untuk keputusan yang mengutamakan pendekatan luasan keadilan, sedangkan **Sugeno** sangat baik jika kita menginginkan proses komputasi ringan dengan ketegasan nilai mutlak, dan **Tsukamoto** cocok untuk pergerakan nilai secara halus (*smooth transisition*).

Aplikasi "Bug Priority Analyzer" secara fungsional 100% siap digunakan dan memenuhi seluruh tujuan pengembangan untuk penyelesaian mata kuliah Kecerdasan Buatan.

---
*Laporan ini di-generate dari dokumentasi aplikasi Bug Priority Analyzer (2026).*
