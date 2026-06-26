# TODO - Hapus Tombol pada Halaman Riwayat

- [ ] Update `app/Http/Controllers/HistoryController.php`: tambahkan method `destroy($id)` untuk menghapus record `Bug` lalu redirect ke `route('history')` dengan flash message.
- [ ] Update `routes/web.php`: tambahkan route `DELETE /history/{id}` menuju `HistoryController@destroy`.
- [ ] Update `resources/views/history.blade.php`: tambahkan kolom “Aksi” dan tombol “Hapus” per baris (menggunakan form `POST` + `@method('DELETE')` + `@csrf`, dengan `confirm()` ).
- [ ] Update colspan pada kondisi `@empty` agar sesuai jumlah kolom tabel.
- [ ] Jalankan testing manual: buka `/history`, pastikan tombol hapus muncul dan setelah diklik record terhapus.

