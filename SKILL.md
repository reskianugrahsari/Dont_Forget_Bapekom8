# Pola Prompt & Eksekusi Berulang (Skill Templates)

Dokumen ini berisi sekumpulan template instruksi prompt dan pola kerja yang dapat digunakan kembali selama proses pengembangan aplikasi Dont Forget untuk menjamin hasil kerja yang konsisten.

## 1. Pengujian Kode & Validasi Fitur
- **Pola**: Jalankan perintah pengujian lokal setiap kali fitur baru ditambahkan atau diubah.
- **Template Prompt**:
  > "Lakukan verifikasi terhadap fitur [nama_fitur] dengan menjalankan test suite proyek menggunakan perintah `php artisan test` atau `vendor/bin/pest`. Laporkan jika ada test case yang gagal beserta penyebabnya."

## 2. Review Keamanan & Sanitasi Input
- **Pola**: Pastikan input dari pengguna telah divalidasi dan disanitasi sebelum masuk ke database. Cegah celah keamanan umum Laravel.
- **Template Prompt**:
  > "Audit keamanan file [file_path] untuk memastikan tidak ada celah terhadap SQL Injection, Cross-Site Scripting (XSS), dan Cross-Site Request Forgery (CSRF). Pastikan form request menggunakan aturan validasi Laravel yang ketat."

## 3. Refaktorisasi Kode (Clean Code)
- **Pola**: Sederhanakan blok kode yang terlalu rumit, terapkan prinsip DRY (Don't Repeat Yourself), dan gunakan helper Laravel secara efisien.
- **Template Prompt**:
  > "Tinjau kembali struktur logika pada method [nama_method] di file [file_path]. Lakukan refaktorisasi untuk menyederhanakan alur eksekusi, meningkatkan efisiensi pembacaan kode, dan pastikan file mematuhi PSR-12 tanpa mengubah fungsionalitas aslinya."

## 4. Pembuatan Migrasi Database
- **Pola**: Pastikan migrasi aman, menggunakan tipe data yang tepat, dan memiliki method rollback (`down`) yang berfungsi penuh.
- **Template Prompt**:
  > "Buat migrasi untuk tabel [nama_tabel] dengan kolom [daftar_kolom]. Pastikan untuk menulis method `down` untuk melakukan drop tabel atau kolom secara aman sehingga proses rollback (`php artisan migrate:rollback`) berjalan mulus."
