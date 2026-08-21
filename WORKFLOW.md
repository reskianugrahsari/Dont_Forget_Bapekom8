# Aturan Main & Alur Kerja (Workflow)

Dokumen ini mendefinisikan batas interaksi antara Agen AI dengan Pengguna serta Kriteria Penyelesaian Fitur (Definition of Done) untuk menjaga kualitas pengembangan proyek SIPAT.

## 1. Batas Interaksi & Persetujuan Tindakan

### Tindakan yang WAJIB meminta izin/konfirmasi Pengguna terlebih dahulu:
- Melakukan instalasi paket eksternal Composer baru yang tidak disebutkan di dalam dokumen PRD.md.
- Melakukan modifikasi skema database (migrasi) pada lingkungan yang sudah memiliki data produksi atau data transaksi riil.
- Melakukan commit Git, membuat branch baru, atau melakukan push perubahan ke repositori git jarak jauh (remote repository).
- Menghapus file kode sumber yang sudah ada sebelumnya.

### Tindakan yang boleh dilakukan secara mandiri (Autonomously):
- Membuat file kode baru (Controller, Model, View, Seeder, Test Case, Filament Resource).
- Mengedit kode yang sudah ada untuk perbaikan bug atau penyesuaian fungsionalitas fitur.
- Menjalankan perintah diagnosis lokal seperti `php artisan test`, `vendor/bin/pint`, `phpstan`, atau php server lokal.

## 2. Kriteria Penyelesaian Tugas (Definition of Done - DoD)
Sebuah fitur atau tugas dinyatakan selesai dan siap diserahkan apabila memenuhi kriteria berikut:
1. **Kesesuaian Kebutuhan**: Seluruh spesifikasi fungsional (FR) dan non-fungsional (NFR) yang didefinisikan pada `PRD.md` untuk fitur terkait telah terimplementasi dengan benar.
2. **Pemeriksaan Gaya Kode (Linting)**: Kode yang ditulis lolos pemeriksaan gaya kode tanpa error menggunakan linter proyek (`vendor/bin/pint`).
3. **Pengujian Mandiri (Testing)**: Semua test case (baik unit test maupun feature test) yang terkait dengan fitur tersebut berhasil dijalankan dan lulus 100%.
4. **Keamanan & Validasi**: Semua input pengguna telah melalui lapisan validasi yang aman dan tidak meninggalkan celah kerentanan baru.
5. **Pembaruan Tracker**: Status tugas pada dokumen `TODO.md` telah diperbarui dari `pending` atau `in_progress` menjadi `completed`.
