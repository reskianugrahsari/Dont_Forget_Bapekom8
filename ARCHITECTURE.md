# Arsitektur Sistem & Rencana Implementasi: DON'T FORGET

## Stack Teknologi (Tech Stack)
- **Backend**: Laravel 11/12/13 (PHP 8.2+) sebagai framework utama yang menyediakan struktur aplikasi, routing, request validation, dan ORM Eloquent.
- **Admin Panel**: Filament v5 untuk pembuatan antarmuka administrasi internal dengan cepat tanpa harus menulis kode HTML/JS dari nol.
- **Frontend Form**: Laravel Blade dipadukan dengan Alpine.js untuk reaktivitas sisi klien (client-side reactivity) dan Tailwind CSS untuk styling.
- **Database (Default)**: SQLite sebagai penyimpanan berbasis file tanpa instalasi server database (`database/database.sqlite`), mendukung kemudahan portabilitas.
- **Database (Alternatif)**: MySQL 8.0+ / MariaDB jika ingin dihubungkan ke server database produksi di masa mendatang.
- **Pencetakan (Printing)**: Browser Native Print API (`window.print()`) memanfaatkan stylesheet CSS `@media print` Tailwind untuk menyembunyikan elemen UI web dan menyisakan format dokumen dinas A4 yang presisi.

## Struktur Direktori & File Kunci
- `app/Models/Pegawai.php`: Representasi data pegawai, memiliki relasi ke model `Atasan` (self-referencing).
- `app/Models/PengajuanAbsen.php`: Representasi pengajuan absen, berelasi dengan `Pegawai` (pemohon) dan `Pegawai` (atasan).
- `app/Filament/Resources/PegawaiResource.php`: Pengaturan halaman CRUD Pegawai di Admin Panel.
- `app/Filament/Resources/PengajuanAbsenResource.php`: Log history pengajuan absen dan filter status.
- `database/migrations/`: File migrasi untuk tabel `pegawai` dan `pengajuan_absen`.
- `resources/views/pengajuan.blade.php`: Halaman publik form pengajuan sekaligus tempat menampilkan *live preview* surat dinas.

## Fase Implementasi & Kriteria Penerimaan (Acceptance Criteria)

### Fase 1: Environment & Database Setup
- Konfigurasi file `.env` untuk menggunakan driver database SQLite.
- Pembuatan dan eksekusi file migrasi untuk tabel `pegawai` dan `pengajuan_absen` sesuai dengan relasi foreign key.
- Pembuatan Model `Pegawai` dan `PengajuanAbsen` beserta konfigurasi relasi Eloquent (`belongsTo`, `hasMany`).
- **Kriteria Penerimaan**: Migrasi berhasil dijalankan (`php artisan migrate`) tanpa error. Struktur tabel di SQLite cocok dengan skema rancangan.

### Fase 2: Filament Admin Panel (Filament v5)
- Instalasi Filament v5 ke dalam proyek Laravel.
- Pembuatan `PegawaiResource` lengkap dengan form input (NIP unik, Dropdown Atasan) dan tabel list pegawai.
- Pembuatan `PengajuanAbsenResource` untuk melihat histori pengajuan, filter berdasarkan rentang tanggal/status, serta menambahkan aksi kustom untuk mencetak ulang dari tabel admin.
- **Kriteria Penerimaan**: Halaman panel admin Filament dapat diakses di `/admin`. Operasi CRUD data pegawai dan log pengajuan absen berfungsi normal.

### Fase 3: Form Publik & Live Preview
- Pembuatan route publik `/pengajuan` beserta file Blade template terkait.
- Integrasi Alpine.js pada form untuk memicu auto-fill data atasan secara reaktif begitu pegawai dipilih.
- Sinkronisasi data form ke kontainer HTML preview surat secara real-time.
- Pembuatan CSS `@media print` yang mengoptimalkan halaman saat dicetak (menghilangkan tombol, menyesuaikan margin A4, mengatur pemisah halaman).
- **Kriteria Penerimaan**: Memilih nama pegawai otomatis mengisi data profilnya dan menampilkan layout surat dinas secara real-time. Klik tombol cetak memunculkan dialog print browser dengan format bersih (tanpa UI web).

### Fase 4: Integrasi Data Seeder & Pengujian
- Pembuatan Seeder Pegawai untuk menghasilkan data hierarki atasan dan bawahan secara otomatis untuk keperluan demo/pengujian.
- Pembuatan unit/feature test menggunakan Pest atau PHPUnit untuk memastikan form pengajuan absen memvalidasi data dengan benar dan menyimpan record baru ke database.
- **Kriteria Penerimaan**: Pengujian otomatis berjalan sukses (`composer test` / `vendor/bin/pest`) dan data dummy pegawai berhasil dimigrasikan serta ditautkan dengan benar.
