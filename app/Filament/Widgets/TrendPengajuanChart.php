<?php

namespace App\Filament\Widgets;

use App\Models\PengajuanAbsen;
use Filament\Widgets\ChartWidget;

class TrendPengajuanChart extends ChartWidget
{
    protected static ?int $sort = 2;

    protected ?string $heading = 'Distribusi Jenis Pengajuan';

    protected function getData(): array
    {
        $masukCount = PengajuanAbsen::where('jenis_absen', 'tidak mengisi absensi masuk')->count();
        $pulangCount = PengajuanAbsen::where('jenis_absen', 'tidak mengisi absensi pulang')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Pengajuan',
                    'data' => [$masukCount, $pulangCount],
                    'backgroundColor' => ['#f59e0b', '#3b82f6'],
                    'borderWidth' => 0,
                    'hoverOffset' => 10,
                ],
            ],
            'labels' => ['Lupa Absen Masuk', 'Lupa Absen Pulang'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
