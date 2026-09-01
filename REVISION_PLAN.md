### 1. PEMBARUAN VISUAL & TEMPLATE SURAT
- Gambar Pemanis UI: Tambahkan ilustrasi/banner visual yang menarik pada halaman utama form pengajuan (misal: vektor ilustrasi absensi/perkantoran) agar tampilan web pemerintah yang modern dan ramah pengguna. Gunakan warna Navy, Kuuning, dan juga baground putih.
- Kop Surat Instansi: gunakan D:\Dont Forget\KOP Surat.jpg sebagai Header Kop Surat Resmi dan (Garis Pembatas Kop) pada bagian atas template preview dan format cetak surat.
- Tipografi / Font Default: Ubah seluruh font default sistem—baik pada Tampilan UI Web maupun Template Cetak Surat—menggunakan jenis font **Tahoma** (`font-family: Tahoma, sans-serif;`).

### 2. PENYESUAIAN DROPDOWN ATASAN LANGSUNG
Restriksi pilihan Atasan Langsung pada form pengajuan dan master data agar secara khusus hanya menampilkan 3 opsi utama penandatangan berikut:
1. Kabalai (Kepala Balai)
2. Bu Wahyuni
3. Bu Sarnaeni

### 3. FITUR BARU: REKAPITULASI BULANAN (FILAMENT ADMIN PANEL)
Tambahkan halaman Widget / Report khusus di Filament Admin Panel untuk rekapitulasi pengajuan lupa absen bulanan:
- Rekap Bulanan per Nama Pegawai: Menampilkan total frekuensi lupa absen yang dilakukan oleh masing-masing pegawai dalam periode bulan & tahun tertentu.
- Rekap Bulanan per Jenis Lupa Absen: Grafik/Tabel rekapitulasi berdasarkan kategori ("tidak mengisi absensi masuk", "tidak mengisi absensi pulang", atau "tidak mengisi absensi masuk dan pulang").
- Filter Periode: Pemilih Bulan (Januari - Desember) dan Tahun.
- Fitur Export Data: Tombol untuk mengunduh rekapitulasi bulanan ke format Excel / PDF.
- Pada fitur ini gunakan tampilan UI dengan menggunakan skill yang sesuai dan jika beli terinstall lakukan penginstalan di skill.sh

