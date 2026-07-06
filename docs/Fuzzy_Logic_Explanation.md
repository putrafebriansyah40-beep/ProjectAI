# Penjelasan Logika Fuzzy dalam Sistem

Aplikasi ini menggunakan tiga metode Logika Fuzzy untuk menentukan skala prioritas perbaikan *bug*. Sistem memproses masukan yang tidak pasti (skala abu-abu) menjadi suatu keputusan yang pasti.

## 1. Variabel Input (Fuzzifikasi)
Sistem menerima 3 variabel *input* utama:
1. **Severity (0-100)**: Seberapa parah dampak teknis dari bug tersebut (misalnya, membuat aplikasi crash vs hanya error tampilan).
2. **Impact (0-100)**: Seberapa besar kerugian operasional dan bisnis yang ditimbulkan.
3. **Affected Users (0-100)**: Seberapa banyak persentase pengguna yang merasakan efek dari bug tersebut.

Masing-masing input dikategorikan ke dalam 3 himpunan fuzzy: **Rendah**, **Sedang**, dan **Tinggi**. 
Sistem menggunakan fungsi keanggotaan kurva trapesium (untuk batas tepi) dan kurva segitiga (untuk himpunan tengah).

## 2. Rule Base (Aturan Fuzzy)
Terdapat **27 aturan logika fuzzy (*rules*)** yang mengevaluasi setiap kemungkinan dari kombinasi input (3 x 3 x 3). 
Beberapa contoh Aturan:
- `[R1]` IF Severity is Tinggi AND Impact is Tinggi AND Users is Tinggi THEN Priority is Critical
- `[R2]` IF Severity is Sedang AND Impact is Sedang AND Users is Rendah THEN Priority is Medium
- `[R3]` IF Severity is Rendah AND Impact is Rendah AND Users is Rendah THEN Priority is Low

## 3. Inferensi & Defuzzifikasi (Perbandingan 3 Metode)
Aplikasi secara berbarengan mengeksekusi 3 algoritma yang berbeda untuk melihat selisih nilai prioritas akhir:

- **Metode Mamdani (Max-Min)**: Menggunakan operasi *min* untuk menentukan *firing strength* (implikasi), dan operasi *max* untuk menggabungkan hasil (agregasi). Nilai *crisp* akhir didapat dengan menghitung titik pusat luasan area (Metode *Centroid*).
- **Metode Sugeno (Orde Nol)**: Mengganti area *output* (konsekuen) dengan nilai konstanta tegak lurus tunggal. Metode *defuzzifikasi*-nya menggunakan rumus *Weighted Average* (Rata-rata Terbobot). Hasilnya biasanya lebih tegas.
- **Metode Tsukamoto**: Konsekuen dari setiap aturan harus direpresentasikan sebagai himpunan monotonik (kurva Z atau kurva S). Nilai output tunggal (*crisp*) juga diperoleh dengan persamaan *Weighted Average*.

Implementasi teknis murni dari masing-masing metode dikapsulasi di dalam arsitektur kode terpisah (di direktori `app/Services/`), sehingga struktur aplikasinya bersih dan terpisah dari *UI Controller*.
