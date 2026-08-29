<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DON'T FORGET - Surat Permohonan Absen & Tata Usaha</title>
    <link rel="manifest" href="{{ route('pwa.manifest') }}">
    <meta name="theme-color" content="#111827">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
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
<body class="bg-slate-50 min-h-screen text-slate-800" x-data="dontForgetApp()">
    <div class="container mx-auto max-w-7xl p-4 md:p-8 no-print">
        <header class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between border-b pb-6 border-slate-200">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">DON'T FORGET</h1>
                <p class="text-slate-500 mt-1 font-medium">Sistem Informasi Permohonan Absen & Tata Usaha</p>
                <p class="text-sm text-slate-400 mt-1">Bisa dipasang ke layar utama sebagai app.</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <button type="button" x-show="canInstallApp" @click="installApp()" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-slate-900 bg-white border border-slate-200 hover:bg-slate-50 transition rounded-lg shadow-sm">
                    Install App
                </button>
                <a href="/admin" class="inline-flex items-center justify-center px-4 py-2 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 transition rounded-lg shadow-sm">
                    Panel Admin
                </a>
            </div>
        </header>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-emerald-800 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Form Input -->
            <div class="lg:col-span-5 bg-white p-8 rounded-2xl border border-slate-100 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900 mb-6">Form Pengajuan Lupa Absen</h2>
                <form action="{{ route('pengajuan.store') }}" method="POST" @submit="submitForm($event)">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Nama Pegawai</label>
                        <select name="pegawai_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900" x-model="selectedPegawaiId" @change="updatePegawaiData()" required>
                            <option value="">-- Pilih Pegawai --</option>
                            <template x-for="item in pegawaiList" :key="item.id">
                                <option :value="item.id" x-text="item.nama + ' - NIP. ' + item.nip"></option>
                            </template>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">NIP</label>
                            <input type="text" class="w-full border border-slate-100 rounded-xl px-4 py-3 bg-slate-50 text-slate-500 font-mono text-sm" x-model="pegawaiData.nip" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Golongan</label>
                            <input type="text" class="w-full border border-slate-100 rounded-xl px-4 py-3 bg-slate-50 text-slate-500 text-sm" x-model="pegawaiData.pangkat_gol" readonly>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-5">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Jabatan</label>
                            <input type="text" class="w-full border border-slate-100 rounded-xl px-4 py-3 bg-slate-50 text-slate-500 text-sm" x-model="pegawaiData.jabatan" readonly>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Bagian</label>
                            <input type="text" class="w-full border border-slate-100 rounded-xl px-4 py-3 bg-slate-50 text-slate-500 text-sm" x-model="pegawaiData.bagian" readonly>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Atasan Penandatangan</label>
                        <select name="atasan_id" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900" x-model="selectedAtasanId" @change="updateAtasanData()" required>
                            <option value="">-- Pilih Atasan --</option>
                            <template x-for="item in pegawaiList" :key="item.id">
                                <option :value="item.id" x-text="item.nama + ' - ' + item.jabatan"></option>
                            </template>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Jenis Lupa Absen</label>
                        <select name="jenis_absen" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900" x-model="jenisAbsen" required>
                            <option value="tidak mengisi absensi masuk">tidak mengisi absensi masuk</option>
                            <option value="tidak mengisi absensi pulang">tidak mengisi absensi pulang</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Alasan</label>
                        <textarea name="alasan" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900" rows="3" x-model="alasan" placeholder="Contoh: lupa, sistem error, mati lampu" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Tanggal Lupa</label>
                            <input type="date" name="tanggal_lupa" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900 text-sm" x-model="tanggalLupa" @input="updateHariLupa()" required>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Tanggal Pengajuan</label>
                            <input type="date" name="tanggal_pengajuan" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900 text-sm" x-model="tanggalPengajuan" required>
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500 mb-2">Kota Surat</label>
                        <input type="text" name="kota_surat" class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-900 focus:border-slate-900 transition-all outline-none text-slate-900 text-sm" x-model="kotaSurat" required>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 px-6 rounded-xl transition duration-150 shadow-sm text-center">
                            Simpan Permohonan
                        </button>
                        <button type="button" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold py-3 px-6 rounded-xl transition duration-150 text-center" @click="window.print()">
                            Cetak / PDF
                        </button>
                    </div>
                </form>
            </div>

            <!-- Live Preview -->
            <div class="lg:col-span-7 bg-slate-200 p-8 rounded-2xl flex justify-center overflow-auto shadow-inner border border-slate-300/50">
                <div class="bg-white shadow-xl border p-12 text-black w-[210mm] min-h-[297mm] flex flex-col justify-between rounded-md">
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
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('{{ route('pwa.sw') }}');
            });
        }

        let deferredPrompt = null;

        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredPrompt = event;
            window.dispatchEvent(new CustomEvent('dont-forget-pwa-available'));
        });

        function dontForgetApp() {
            return {
                canInstallApp: false,
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

                    // Hitung tanggal pengajuan otomatis H+1 kerja
                    let nextDate = new Date(date);
                    if (date.getDay() === 5) { // Jumat -> Senin (H+3)
                        nextDate.setDate(date.getDate() + 3);
                    } else if (date.getDay() === 6) { // Sabtu -> Senin (H+2)
                        nextDate.setDate(date.getDate() + 2);
                    } else { // Hari lainnya -> Besoknya (H+1)
                        nextDate.setDate(date.getDate() + 1);
                    }
                    this.tanggalPengajuan = nextDate.toISOString().split('T')[0];
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
                installApp() {
                    if (!deferredPrompt) return;

                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.finally(() => {
                        deferredPrompt = null;
                        this.canInstallApp = false;
                    });
                },
                submitForm(e) {
                    // Biarkan submit form Laravel POST normal berjalan
                }
            };
        }
    </script>
</body>
</html>
