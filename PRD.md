# Product Requirement Document (PRD)

## 1. Overview & Document History

* **Nama Produk:** DON'T FORGET (Sistem Informasi Permohonan Absen & Tata Usaha)
* **Versi Dokumen:** 2.0
* **Status:** Final / Approved for Development
* **Target Release:** Q3 2026
* **Penulis / Pemilik:** Tim Sistem Informasi Instansi

---

## 2. Executive Summary & Objectives

### 2.1 Latar Belakang

Pengajuan surat permohonan izin/pemberitahuan lupa absen di lingkungan instansi saat ini masih menggunakan proses manual berbasis kertas atau pengetikan terpisah. Hal ini berpotensi memicu ketidaksesuaian format naskah dinas, kesalahan input data pegawai (NIP, Pangkat/Golongan, Jabatan), serta hilangnya rekam jejak riwayat pengajuan.

### 2.2 Tujuan Utama

* **Otomatisasi Dokumen:** Mengubah pengisian form digital menjadi dokumen *Surat Permohonan Izin/Pemberitahuan* siap cetak sesuai format resmi dinas.
* **Integrasi Master Data:** Menghubungkan form pengajuan secara otomatis dengan Master Data Pegawai sehingga NIP, Pangkat/Gol, Jabatan, dan Atasan Langsung terisi secara akurat (*read-only*).
* **Kemudahan Manajemen:** Memanfaatkan Admin Panel modern berbasis Filament v5 untuk pengelolaan data pegawai dan log pengajuan secara terpusat.
* **Efisiensi Setup:** Menggunakan SQLite sebagai database default agar aplikasi bersifat *zero-config* dan mudah dijalankan di lingkungan instansi tanpa setup database server yang rumit.

---

## 3. User Roles & Personas

| Role | Deskripsi Hak Akses & Tanggung Jawab |
| --- | --- |
| **Pegawai (User)** | Mengakses form pengajuan publik/internal, memilih nama pegawai, mengisi alasan & tanggal, melihat *live preview* surat, serta mencetak dokumen. |
| **Atasan Langsung** | Meninjau pengajuan bawahan melalui Admin Panel, mengubah status permohonan (*Pending / Disetujui / Ditolak*), dan menandatangani fisik/digital. |
| **Administrator System** | Mengelola *Master Data Pegawai* (NIP, Pangkat, Jabatan, Bagian, Relasi Atasan), mengelola pengguna Admin Panel, dan mengunduh rekapitulasi data. |

---

## 4. Feature Specifications & Requirements

### 4.1 Functional Requirements (FR)

**FR-01: Master Data Pegawai (Filament Admin Panel)**

* Pengelolaan data pegawai (CRUD) meliputi: NIP, Nama, Pangkat/Golongan, Jabatan, Bagian, dan Atasan Langsung.
* Relasi hirarki atasan langsung (Self-Referencing Foreign Key `atasan_id`).

**FR-02: Form Input Pengajuan Lupa Absen**

* **Nama Pegawai:** Dropdown / Autocomplete dengan pencarian berbasis nama atau NIP.
* **Auto-fill Data:** Saat nama dipilih, sistem otomatis mengisi NIP, Pangkat/Gol, Jabatan, Bagian, dan Atasan Langsung.
* **Jenis Lupa Absen:** Choice Field dengan pilihan:
1. *tidak mengisi absensi masuk*
2. *tidak mengisi absensi pulang*


* **Alasan:** Text input / Textarea (contoh: *lupa*, *sistem error*, *mati lampu*).
* **Tanggal Lupa Absen:** Datepicker yang otomatis mengekstrak nama Hari (contoh: *Rabu, 28 Mei 2025*).
* **Tanggal Pengajuan:** Datepicker otomatis terisi tanggal hari ini ($H+1$ / Real-time).
* **Atasan Penandatangan:** Otomatis terisi sesuai hirarki atasan pegawai, namun dapat diubah secara eksplisit jika atasan sedang Plt/Plh.

**FR-03: Live Preview & Template Cetak Dinas**

* Menampilkan *live preview* fisik surat di sisi kanan/bawah form pengajuan secara real-time.
* Template surat memuat:
* Judul: **SURAT PERMOHONAN IZIN/PEMBERITAHUAN**
* Identitas Pemohon (Nama, NIP, Pangkat/Gol, Jabatan)
* Kalimat Pernyataan Alasan & Jenis Absensi
* Bagian Tanda Tangan 2 Kolom (Kiri: Pegawai, Kanan: Atasan Langsung)


* Tombol **Cetak / PDF** dengan CSS Print yang menyembunyikan semua elemen UI web (navbar, tombol, form) dan menyisakan dokumen siap cetak A4.

**FR-04: Log & Histori Pengajuan (Filament Admin Panel)**

* Setiap permohonan tersimpan ke database.
* Admin dan Atasan dapat memfilter log berdasarkan tanggal, bagian, atau status permohonan.
* *Custom Action* pada Filament Table untuk melakukan pencetakan ulang surat dari riwayat.

---

### 4.2 Non-Functional Requirements (NFR)

* **Performance:** Proses auto-fill data dan pencetakan preview surat < 1 detik.
* **Database Portability:** Menggunakan SQLite sebagai driver default. Sistem dapat dipindahkan ke MySQL/PostgreSQL hanya dengan mengubah konfigurasi file `.env`.
* **Print Standards:** Layout cetak mematuhi standar margin naskah dinas (Standar A4, Margin 4-2-2-2 cm).
* **Security:** Proteksi CSRF pada form, sanitize input untuk mencegah XSS & SQL Injection.

### 4.3 Out of Scope (Di Luar Scope)

* **Integrasi Biometrik:** Tidak mencakup sinkronisasi dengan mesin absensi fisik/sidik jari.
* **Tanda Tangan Elektronik Tersertifikasi:** Sistem tidak menggunakan sertifikat otoritas digital resmi (e.g., BSrE) untuk tanda tangan. Tanda tangan dilakukan secara basah setelah dokumen dicetak atau tanda tangan gambar biasa.
* **Aplikasi Mobile Native:** Aplikasi dibangun berbasis web responsive, bukan mobile app (Android/iOS).

---

## 5. Technical Stack & System Architecture

| Layer | Teknologi Utama | Deskripsi |
| --- | --- | --- |
| **Backend Framework** | Laravel versi 12 terbaru | Engine utama logic bisnis, routing, dan ORM |
| **Admin Panel** | **Filament v5** | Dashboard admin untuk CRUD Pegawai & Log Pengajuan |
| **Frontend Form** | Blade + Alpine.js + Tailwind CSS | Form interaktif & reactive live preview |
| **Database (Default)** | **SQLite** | Database berbasis file (`database/database.sqlite`), *zero-config* |
| **Database (Optional)** | MySQL 8.0+ / MariaDB | Pilihan database alternatif untuk skala besar |
| **Printing Engine** | Browser Native Print API (`window.print()`) | Cetak langsung via browser dengan CSS `@media print` |

---

## 6. Database Schema & Data Structure

### 6.1 Tabel `pegawai`

```sql
CREATE TABLE pegawai (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nip VARCHAR(50) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    pangkat_gol VARCHAR(50) NOT NULL,
    jabatan VARCHAR(100) NOT NULL,
    bagian VARCHAR(100) NOT NULL,
    atasan_id INTEGER NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (atasan_id) REFERENCES pegawai(id) ON DELETE SET NULL
);

```

### 6.2 Tabel `pengajuan_absen`

```sql
CREATE TABLE pengajuan_absen (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nomor_surat VARCHAR(100) NULL,
    pegawai_id INTEGER NOT NULL,
    atasan_id INTEGER NOT NULL,
    jenis_absen VARCHAR(100) NOT NULL, -- Enum: 'tidak mengisi absensi masuk', dll.
    alasan TEXT NOT NULL,
    tanggal_lupa DATE NOT NULL,
    tanggal_pengajuan DATE NOT NULL,
    kota_surat VARCHAR(50) DEFAULT 'Makassar',
    status VARCHAR(20) DEFAULT 'pending', -- 'pending', 'disetujui', 'ditolak'
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (pegawai_id) REFERENCES pegawai(id) ON DELETE CASCADE,
    FOREIGN KEY (atasan_id) REFERENCES pegawai(id) ON DELETE CASCADE
);

```

---

## 7. Environment Setup (`.env`)

Default konfigurasi database berbasis SQLite:

```env
APP_NAME="DON'T FORGET"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=Asia/Makassar
APP_URL=http://localhost:8000

# Default Database Configuration (SQLite)
DB_CONNECTION=sqlite
# File database tersimpan otomatis di: database/database.sqlite

```

---

## 8. Implementation Roadmap

```
[Phase 1: Environment & Admin Panel Setup]
 ├── Setup Laravel 11/12/13 + SQLite
 ├── Instalasi Filament v5
 ├── Migration & Model (Pegawai, PengajuanAbsen)
 └── Buat Filament Resources (PegawaiResource & PengajuanAbsenResource)

[Phase 2: Frontend Form & Live Preview]
 ├── Layout Form Pengajuan Lupa Absen
 ├── Integrasi Alpine.js untuk Auto-fill Data & Dynamic Preview
 └── CSS `@media print` untuk Format Surat Dinas

[Phase 3: Integration & Testing]
 ├── Pengujian Alur Input -> Preview -> Save DB -> Cetak
 ├── Pengujian Relasi Atasan Langsung
 └── Seeding Data Dummy Pegawai

```