<?php

namespace App\Filament\Widgets;

use App\Models\Pegawai;
use App\Models\PengajuanAbsen;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pengajuan Perlu Verifikasi', PengajuanAbsen::where('status', 'pending')->count())
                ->color('warning')
                ->description('Cek format naskah dinas & data pegawai'),
            Stat::make('Pengajuan Disetujui Bulan Ini', PengajuanAbsen::where('status', 'disetujui')->whereMonth('created_at', now()->month)->count())
                ->color('success'),
            Stat::make('Pengajuan Ditolak / Perlu Revisi', PengajuanAbsen::where('status', 'ditolak')->count())
                ->color('danger'),
            Stat::make('Total Pegawai Terdaftar', Pegawai::whereNotNull('nip')->count())
                ->color('info'),
        ];
    }
}
