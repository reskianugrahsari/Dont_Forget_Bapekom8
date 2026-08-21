<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIPAT - Surat Permohonan Absen & Tata Usaha</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @media print {
            body {
                background: white;
                color: black;
            }
            .no-print {
                display: none !important;
            }
            .print-area {
                width: 210mm;
                height: 297mm;
                padding: 40mm 20mm 20mm 20mm; /* Margin naskah dinas 4-2-2-2 cm */
                margin: 0;
                border: none;
                box-shadow: none;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800" x-data="sipatApp()">
    <div class="container mx-auto p-4 md:p-8 no-print">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-blue-600">SIPAT</h1>
            <p class="text-gray-600 font-medium">Sistem Informasi Permohonan Absen & Tata Usaha</p>
        </header>

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Form Input -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-6">Form Pengajuan Lupa Absen</h2>
                <form action="{{ route('pengajuan.store') }}" method="POST" @submit="submitForm($event)">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Nama Pegawai</label>
                        <select name="pegawai_id" class="w-full border rounded-md px-3 py-2" x-model="selectedPegawaiId" @change="updatePegawaiData()" required>
                            <option value="">-- Pilih Pegawai --</option>
                            <template x-for="item in pegawaiList" :key="item.id">
                                <option :value="item.id" x-text="item.nama + ' - NIP. ' + item.nip"></option>
                            </template>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">NIP</label>
                            <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-50 text-gray-500" x-model="pegawaiData.nip" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Pangkat/Golongan</label>
                            <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-50 text-gray-500" x-model="pegawaiData.pangkat_gol" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Jabatan</label>
                            <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-50 text-gray-500" x-model="pegawaiData.jabatan" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Bagian</label>
                            <input type="text" class="w-full border rounded-md px-3 py-2 bg-gray-50 text-gray-500" x-model="pegawaiData.bagian" readonly>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Atasan Penandatangan</label>
                        <select name="atasan_id" class="w-full border rounded-md px-3 py-2" x-model="selectedAtasanId" @change="updateAtasanData()" required>
                            <option value="">-- Pilih Atasan --</option>
                            <template x-for="item in pegawaiList" :key="item.id">
                                <option :value="item.id" x-text="item.nama + ' - ' + item.jabatan"></option>
                            </template>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Jenis Lupa Absen</label>
                        <select name="jenis_absen" class="w-full border rounded-md px-3 py-2" x-model="jenisAbsen" required>
                            <option value="tidak mengisi absensi masuk">tidak mengisi absensi masuk</option>
                            <option value="tidak mengisi absensi pulang">tidak mengisi absensi pulang</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Alasan</label>
                        <textarea name="alasan" class="w-full border rounded-md px-3 py-2" rows="3" x-model="alasan" placeholder="Contoh: lupa, sistem error, mati lampu" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Lupa Absen</label>
                            <input type="date" name="tanggal_lupa" class="w-full border rounded-md px-3 py-2" x-model="tanggalLupa" @input="updateHariLupa()" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" class="w-full border rounded-md px-3 py-2" x-model="tanggalPengajuan" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium mb-1">Kota Surat</label>
                        <input type="text" name="kota_surat" class="w-full border rounded-md px-3 py-2" x-model="kotaSurat" required>
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2 rounded-md">Simpan Permohonan</button>
                        <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-md" @click="window.print()">Cetak / PDF</button>
                    </div>
                </form>
            </div>

            <!-- Live Preview -->
            <div class="bg-gray-200 p-6 rounded-lg flex justify-center overflow-auto">
                <div class="bg-white shadow-lg border p-12 text-black w-[210mm] min-h-[297mm] flex flex-col justify-between">
                    <div>
                        <!-- Judul -->
                        <div class="text-center font-bold text-lg mb-8 uppercase underline decoration-2">
                            Surat Permohonan Izin / Pemberitahuan
                        </div>

                        <!-- Paragraf Pembuka -->
                        <div class="mb-6 leading-relaxed">
                            Yang bertanda tangan di bawah ini:
                        </div>

                        <!-- Identitas Pemohon -->
                        <div class="grid grid-cols-[150px_20px_1fr] gap-y-2 mb-8 ml-8">
                            <div>Nama</div><div>:</div><div class="font-semibold" x-text="pegawaiData.nama || '-'"></div>
                            <div>NIP</div><div>:</div><div x-text="pegawaiData.nip || '-'"></div>
                            <div>Pangkat/Golongan</div><div>:</div><div x-text="pegawaiData.pangkat_gol || '-'"></div>
                            <div>Jabatan</div><div>:</div><div x-text="pegawaiData.jabatan || '-'"></div>
                            <div>Bagian</div><div>:</div><div x-text="pegawaiData.bagian || '-'"></div>
                        </div>

                        <!-- Pernyataan -->
                        <div class="leading-relaxed mb-6">
                            Dengan ini menyampaikan bahwa saya <span class="font-semibold" x-text="jenisAbsen"></span> pada hari <span class="font-semibold" x-text="hariLupa || '-'"></span>, tanggal <span class="font-semibold" x-text="formatDateIndo(tanggalLupa) || '-'"></span> dikarenakan <span class="font-semibold" x-text="alasan || '...'"></span>.
                        </div>

                        <div class="leading-relaxed mb-12">
                            Demikian permohonan/pemberitahuan ini saya sampaikan, atas perhatian Bapak/Ibu diucapkan terima kasih.
                        </div>
                    </div>

                    <!-- Tanda Tangan -->
                    <div>
                        <div class="text-right mb-12" x-text="(kotaSurat || 'Makassar') + ', ' + (formatDateIndo(tanggalPengajuan) || '-')"></div>
                        <div class="grid grid-cols-2 gap-8 text-center">
                            <div>
                                <div class="mb-20">Pegawai Pemohon,</div>
                                <div class="font-bold underline" x-text="pegawaiData.nama || 'Nama Pemohon'"></div>
                                <div class="text-sm" x-text="pegawaiData.nip ? 'NIP. ' + pegawaiData.nip : ''"></div>
                            </div>
                            <div>
                                <div class="mb-20">Atasan Langsung,</div>
                                <div class="font-bold underline" x-text="atasanData.nama || 'Nama Atasan'"></div>
                                <div class="text-sm" x-text="atasanData.nip ? 'NIP. ' + atasanData.nip : ''"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cetak Area (Hanya Muncul saat window.print()) -->
    <div class="hidden print:block print-area mx-auto bg-white text-black text-sm">
        <div class="text-center font-bold text-xl mb-12 uppercase underline decoration-2">
            Surat Permohonan Izin / Pemberitahuan
        </div>

        <div class="mb-6 leading-relaxed">
            Yang bertanda tangan di bawah ini:
        </div>

        <div class="grid grid-cols-[180px_20px_1fr] gap-y-3 mb-10 ml-10 text-base">
            <div>Nama</div><div>:</div><div class="font-bold" x-text="pegawaiData.nama || '-'"></div>
            <div>NIP</div><div>:</div><div x-text="pegawaiData.nip || '-'"></div>
            <div>Pangkat/Golongan</div><div>:</div><div x-text="pegawaiData.pangkat_gol || '-'"></div>
            <div>Jabatan</div><div>:</div><div x-text="pegawaiData.jabatan || '-'"></div>
            <div>Bagian</div><div>:</div><div x-text="pegawaiData.bagian || '-'"></div>
        </div>

        <div class="leading-relaxed mb-8 text-base">
            Dengan ini menyampaikan bahwa saya <span class="font-bold" x-text="jenisAbsen"></span> pada hari <span class="font-bold" x-text="hariLupa || '-'"></span>, tanggal <span class="font-bold" x-text="formatDateIndo(tanggalLupa) || '-'"></span> dikarenakan <span class="font-bold" x-text="alasan || '...'"></span>.
        </div>

        <div class="leading-relaxed mb-16 text-base">
            Demikian permohonan/pemberitahuan ini saya sampaikan, atas perhatian Bapak/Ibu diucapkan terima kasih.
        </div>

        <div class="mt-20">
            <div class="text-right mb-16 text-base" x-text="(kotaSurat || 'Makassar') + ', ' + (formatDateIndo(tanggalPengajuan) || '-')"></div>
            <div class="grid grid-cols-2 gap-12 text-center text-base">
                <div>
                    <div class="mb-24">Pegawai Pemohon,</div>
                    <div class="font-bold underline" x-text="pegawaiData.nama || 'Nama Pemohon'"></div>
                    <div x-text="pegawaiData.nip ? 'NIP. ' + pegawaiData.nip : ''"></div>
                </div>
                <div>
                    <div class="mb-24">Atasan Langsung,</div>
                    <div class="font-bold underline" x-text="atasanData.nama || 'Nama Atasan'"></div>
                    <div x-text="atasanData.nip ? 'NIP. ' + atasanData.nip : ''"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function sipatApp() {
            return {
                pegawaiList: @json($pegawai),
                selectedPegawaiId: '',
                selectedAtasanId: '',
                jenisAbsen: 'tidak mengisi absensi masuk',
                alasan: '',
                tanggalLupa: '',
                tanggalPengajuan: new Date().toISOString().split('T')[0],
                kotaSurat: 'Makassar',
                hariLupa: '',
                pegawaiData: {
                    nama: '',
                    nip: '',
                    pangkat_gol: '',
                    jabatan: '',
                    bagian: ''
                },
                atasanData: {
                    nama: '',
                    nip: ''
                },
                updatePegawaiData() {
                    const peg = this.pegawaiList.find(p => p.id == this.selectedPegawaiId);
                    if (peg) {
                        this.pegawaiData = {
                            nama: peg.nama,
                            nip: peg.nip,
                            pangkat_gol: peg.pangkat_gol,
                            jabatan: peg.jabatan,
                            bagian: peg.bagian
                        };
                        if (peg.atasan_id) {
                            this.selectedAtasanId = peg.atasan_id;
                            this.updateAtasanData();
                        } else {
                            this.selectedAtasanId = '';
                            this.atasanData = { nama: '', nip: '' };
                        }
                    } else {
                        this.pegawaiData = { nama: '', nip: '', pangkat_gol: '', jabatan: '', bagian: '' };
                        this.selectedAtasanId = '';
                        this.atasanData = { nama: '', nip: '' };
                    }
                },
                updateAtasanData() {
                    const atasan = this.pegawaiList.find(p => p.id == this.selectedAtasanId);
                    if (atasan) {
                        this.atasanData = {
                            nama: atasan.nama,
                            nip: atasan.nip
                        };
                    } else {
                        this.atasanData = { nama: '', nip: '' };
                    }
                },
                updateHariLupa() {
                    if (!this.tanggalLupa) {
                        this.hariLupa = '';
                        return;
                    }
                    const date = new Date(this.tanggalLupa);
                    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    this.hariLupa = days[date.getDay()];
                },
                formatDateIndo(dateStr) {
                    if (!dateStr) return '';
                    const date = new Date(dateStr);
                    const months = [
                        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                    ];
                    return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
                },
                submitForm(e) {
                    // Biarkan submit form Laravel POST normal berjalan
                }
            };
        }
    </script>
</body>
</html>
