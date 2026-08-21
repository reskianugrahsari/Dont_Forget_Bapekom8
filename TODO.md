# Pelacak Tugas Proyek (Task Tracker)

Progres pengerjaan fitur dan sistem aplikasi Dont Forget dilacak menggunakan tabel di bawah ini.

| ID Tugas | Deskripsi Tugas | Komponen | Status | Target Penyelesaian |
|---|---|---|---|---|
| TS-00a | Inisialisasi proyek baru Laravel 11/12/13 menggunakan Composer | Setup | completed | Fase 1: Setup Awal |
| TS-00b | Instalasi dan setup Filament v5 beserta dependencies terkait | Setup | completed | Fase 1: Setup Awal |
| TS-01 | Inisialisasi Database SQLite & File `.sqlite` di folder `database` | Database | completed | Fase 1: Setup Awal |
| TS-02 | Pembuatan file migrasi tabel `pegawai` dan `pengajuan_absen` | Database | completed | Fase 1: Setup Awal |
| TS-03 | Pembuatan Model `Pegawai` dengan relasi hierarki self-referencing (`atasan_id`) | Models | completed | Fase 1: Setup Awal |
| TS-04 | Pembuatan Model `PengajuanAbsen` dengan relasi `pegawai` & `atasan` | Models | completed | Fase 1: Setup Awal |
| TS-05 | Instalasi Filament v5 dan konfigurasi panel admin awal | Admin | completed | Fase 2: Admin Panel |
| TS-06 | Implementasi `PegawaiResource` (Form CRUD dengan relasi dropdown atasan) | Admin | completed | Fase 2: Admin Panel |
| TS-07 | Implementasi `PengajuanAbsenResource` (Halaman log, filter, custom print action) | Admin | completed | Fase 2: Admin Panel |
| TS-08 | Pembuatan route publik & layout Blade form pengajuan izin absen | Frontend | completed | Fase 3: Form Publik |
| TS-09 | Integrasi Alpine.js untuk fitur auto-fill detail pegawai & live preview surat | Frontend | completed | Fase 3: Form Publik |
| TS-10 | Penulisan stylesheet CSS `@media print` untuk standardisasi format A4 dinas | Frontend | completed | Fase 3: Form Publik |
| TS-11 | Pembuatan data seeder (`PegawaiSeeder`) untuk data hierarki pegawai dinas | Testing | completed | Fase 4: Pengujian |
| TS-12 | Pembuatan unit/feature test untuk validasi form & penyimpanan data pengajuan | Testing | completed | Fase 4: Pengujian |
| TS-13 | Pemeriksaan static analisis kode (`phpstan`) dan format gaya kode (`pint`) | Linting | completed | Fase 4: Pengujian |
