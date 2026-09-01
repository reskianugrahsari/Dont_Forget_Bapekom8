<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Filter Card: Navy + Yellow -->
        <div class="rounded-xl bg-[#0b192c] p-6 text-white shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
            <div class="flex flex-col gap-6">
                <!-- Row 1: Title and Main Period filters -->
                <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                    <div class="space-y-1 text-center md:text-left">
                        <h2 class="text-xl font-bold tracking-tight">Filter Periode Laporan</h2>
                        <p class="text-xs text-slate-300">Silakan pilih bulan dan tahun untuk menyaring data rekapitulasi.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 w-full md:w-auto min-w-[300px]">
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-yellow-400 mb-1.5">Bulan</label>
                            <select wire:model.live="bulan" class="w-full border border-slate-500/30 rounded-lg bg-white/10 text-white px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500 transition">
                                <option value="" class="bg-slate-900 text-white">Semua Bulan</option>
                                <option value="1" class="bg-slate-900 text-white">Januari</option>
                                <option value="2" class="bg-slate-900 text-white">Februari</option>
                                <option value="3" class="bg-slate-900 text-white">Maret</option>
                                <option value="4" class="bg-slate-900 text-white">April</option>
                                <option value="5" class="bg-slate-900 text-white">Mei</option>
                                <option value="6" class="bg-slate-900 text-white">Juni</option>
                                <option value="7" class="bg-slate-900 text-white">Juli</option>
                                <option value="8" class="bg-slate-900 text-white">Agustus</option>
                                <option value="9" class="bg-slate-900 text-white">September</option>
                                <option value="10" class="bg-slate-900 text-white">Oktober</option>
                                <option value="11" class="bg-slate-900 text-white">November</option>
                                <option value="12" class="bg-slate-900 text-white">Desember</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-yellow-400 mb-1.5">Tahun</label>
                            <select wire:model.live="tahun" class="w-full border border-slate-500/30 rounded-lg bg-white/10 text-white px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500 transition">
                                @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                    <option value="{{ $y }}" class="bg-slate-900 text-white">{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Row 2: Search and Category filters -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-slate-700/50 pt-4">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-yellow-400 mb-1.5">Cari Nama Pegawai</label>
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Masukkan nama pegawai..." class="w-full border border-slate-500/30 rounded-lg bg-white/10 text-white placeholder-slate-400 px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500 transition" />
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-yellow-400 mb-1.5">Jenis Lupa Absen</label>
                        <select wire:model.live="jenisAbsen" class="w-full border border-slate-500/30 rounded-lg bg-white/10 text-white px-3 py-2 outline-none focus:ring-2 focus:ring-yellow-500 transition">
                            <option value="" class="bg-slate-900 text-white">Semua Kategori</option>
                            <option value="tidak mengisi absensi masuk" class="bg-slate-900 text-white">Tidak mengisi absensi masuk</option>
                            <option value="tidak mengisi absensi pulang" class="bg-slate-900 text-white">Tidak mengisi absensi pulang</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Side: Table of Pegawai -->
            <div class="lg:col-span-2 space-y-6">
                <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-gray-900 dark:text-white">Frekuensi Lupa Absen per Pegawai</h3>
                    </div>

                    <div class="overflow-x-auto rounded-lg border border-gray-200 dark:border-gray-700">
                        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                            <thead class="text-xs uppercase bg-[#0b192c] text-white">
                                <tr>
                                    <th class="px-6 py-3">No</th>
                                    <th class="px-6 py-3">Nama Pegawai</th>
                                    <th class="px-6 py-3">NIP</th>
                                    <th class="px-6 py-3 text-center bg-amber-600/80">Lupa Datang</th>
                                    <th class="px-6 py-3 text-center bg-blue-600/80">Lupa Pulang</th>
                                    <th class="px-6 py-3 text-right bg-yellow-500 text-[#0b192c] font-bold">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->getPegawaiData() as $index => $row)
                                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-[#0b192c] text-yellow-400 font-bold flex items-center justify-center text-xs shrink-0">
                                                    {{ strtoupper(substr($row['nama'], 0, 2)) }}
                                                </div>
                                                <span>{{ $row['nama'] }}</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 font-mono text-xs text-gray-400">{{ $row['nip'] }}</td>
                                        <td class="px-6 py-4 text-center font-semibold text-amber-600 dark:text-amber-400">
                                            {{ $row['total_masuk'] }}x
                                        </td>
                                        <td class="px-6 py-4 text-center font-semibold text-blue-600 dark:text-blue-400">
                                            {{ $row['total_pulang'] }}x
                                        </td>
                                        <td class="px-6 py-4 text-right font-bold text-[#0b192c] dark:text-yellow-400">
                                            {{ $row['total_frekuensi'] }}x
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">Tidak ada data untuk periode ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right Side: Jenis Lupa Absen Breakdown -->
            <div class="space-y-6">
                <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-6">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4">Breakdown Kategori Lupa Absen</h3>
                    @php
                        $jenis = $this->getJenisData();
                        $totalAll = array_sum($jenis);
                    @endphp
                    <div class="space-y-4">
                        <!-- Masuk -->
                        <div class="p-4 rounded-lg bg-amber-50 dark:bg-amber-950/20 border border-amber-200/50 dark:border-amber-800/30">
                            <div class="flex justify-between text-sm mb-1.5">
                                <span class="font-medium text-amber-800 dark:text-amber-400">Lupa Absen Datang (Masuk)</span>
                                <span class="font-bold text-amber-900 dark:text-amber-300">{{ $jenis['masuk'] }} ({{ $totalAll > 0 ? round(($jenis['masuk'] / $totalAll) * 100) : 0 }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-amber-500 h-2.5 rounded-full" style="width: {{ $totalAll > 0 ? ($jenis['masuk'] / $totalAll) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <!-- Pulang -->
                        <div class="p-4 rounded-lg bg-blue-50 dark:bg-blue-950/20 border border-blue-200/50 dark:border-blue-800/30">
                            <div class="flex justify-between text-sm mb-1.5">
                                <span class="font-medium text-blue-800 dark:text-blue-400">Lupa Absen Pulang</span>
                                <span class="font-bold text-blue-900 dark:text-blue-300">{{ $jenis['pulang'] }} ({{ $totalAll > 0 ? round(($jenis['pulang'] / $totalAll) * 100) : 0 }}%)</span>
                            </div>
                            <div class="w-full bg-gray-200 dark:bg-gray-700 h-2.5 rounded-full overflow-hidden">
                                <div class="bg-blue-500 h-2.5 rounded-full" style="width: {{ $totalAll > 0 ? ($jenis['pulang'] / $totalAll) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
