<?php

namespace App\Filament\Widgets;

use App\Models\PengajuanAbsen;
use Filament\Widgets\ChartWidget;

class TrendPengajuanChart extends ChartWidget
{
    protected static ?int $sort = 3;

    protected ?string $heading = 'Tren Pengajuan Lupa Absen';

    protected function getData(): array
    {
        $masukCount = PengajuanAbsen::where('jenis_absen', 'tidak mengisi absensi masuk')->count();
        $pulangCount = PengajuanAbsen::where('jenis_absen', 'tidak mengisi absensi pulang')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Lupa Absen',
                    'data' => [$masukCount, $pulangCount],
                    'backgroundColor' => ['#f59e0b', '#3b82f6'],
                ],
            ],
            'labels' => ['Lupa Absen Masuk', 'Lupa Absen Pulang'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
