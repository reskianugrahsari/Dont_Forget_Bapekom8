# Instruksi Agen: Proyek Dont Forget

## Standar Pengodean
- Bahasa: PHP 8.2+, Laravel 11/12/13, Filament v5.
- Gaya Kode: Ikuti aturan PSR-12. Jangan menambahkan komentar pada kode kecuali diminta secara eksplisit oleh pengguna.
- Kode Bersih (Clean Code): Gunakan deklarasi tipe data yang ketat (`declare(strict_types=1);`) pada file PHP baru. Jaga agar method controller tetap tipis. Gunakan Form Request untuk memisahkan logika validasi.
- Database: Gunakan SQLite secara default. Semua file migrasi database harus aman saat di-rollback (menyediakan method `down()` yang membersihkan tabel dan kolom dengan benar).

## Pengujian & Linting (Pemeriksaan Kode)
- Kerangka Pengujian: Gunakan Pest atau PHPUnit. Periksa konfigurasi di folder root proyek sebelum menulis test case baru.
- Perintah Lint: Jalankan `composer test` atau `vendor/bin/pint` sebelum menyelesaikan tugas.
- Perintah Typecheck: Jalankan `vendor/bin/phpstan analyse` jika PHPStan telah terinstal di proyek.

## Aturan Interaksi
- Jangan melakukan commit git atau push ke repository jarak jauh kecuali diminta secara tertulis oleh pengguna.
- Selalu jalankan pengujian (test suite) dan alat linting sebelum menyatakan suatu fitur atau tugas telah selesai.
- Jika menemukan error saat instalasi paket, segera laporkan ke pengguna dan tanyakan solusinya sebelum mencoba perbaikan yang merusak sistem.
