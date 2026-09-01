<?php

declare(strict_types=1);

namespace App\Filament\Pages;

use App\Models\PengajuanAbsen;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RekapBulanan extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationLabel = 'Rekap Bulanan';

    protected static ?string $title = 'Rekapitulasi Bulanan Lupa Absen';

    protected string $view = 'filament.pages.rekap-bulanan';

    public ?string $bulan = null;

    public ?string $tahun = null;

    public ?string $search = '';

    public ?string $jenisAbsen = '';

    public function mount(): void
    {
        $this->bulan = (string) now()->month;
        $this->tahun = (string) now()->year;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('exportExcel')
                ->label('Unduh Excel')
                ->action(fn () => $this->exportExcel())
                ->color('success')
                ->icon('heroicon-o-document-arrow-down'),
            Action::make('exportPdf')
                ->label('Unduh PDF (Print)')
                ->action(fn () => $this->exportPdf())
                ->color('danger')
                ->icon('heroicon-o-printer')
                ->extraAttributes(['onclick' => 'window.print(); return false;']),
        ];
    }

    public function getPegawaiData(): array
    {
        $query = PengajuanAbsen::query()
            ->join('pegawai', 'pengajuan_absen.pegawai_id', '=', 'pegawai.id')
            ->select(
                'pegawai.nama',
                'pegawai.nip',
                DB::raw('count(pengajuan_absen.id) as total_frekuensi'),
                DB::raw("sum(case when pengajuan_absen.jenis_absen = 'tidak mengisi absensi masuk' then 1 else 0 end) as total_masuk"),
                DB::raw("sum(case when pengajuan_absen.jenis_absen = 'tidak mengisi absensi pulang' then 1 else 0 end) as total_pulang")
            )
            ->groupBy('pegawai.id', 'pegawai.nama', 'pegawai.nip');

        if ($this->bulan) {
            $query->whereMonth('tanggal_lupa', $this->bulan);
        }
        if ($this->tahun) {
            $query->whereYear('tanggal_lupa', $this->tahun);
        }
        if ($this->search) {
            $query->where('pegawai.nama', 'like', '%'.$this->search.'%');
        }
        if ($this->jenisAbsen) {
            $query->where('pengajuan_absen.jenis_absen', $this->jenisAbsen);
        }

        return $query->orderByDesc('total_frekuensi')->get()->toArray();
    }

    public function getJenisData(): array
    {
        $query = PengajuanAbsen::query()
            ->join('pegawai', 'pengajuan_absen.pegawai_id', '=', 'pegawai.id')
            ->select('jenis_absen', DB::raw('count(pengajuan_absen.id) as total'))
            ->groupBy('jenis_absen');

        if ($this->bulan) {
            $query->whereMonth('tanggal_lupa', $this->bulan);
        }
        if ($this->tahun) {
            $query->whereYear('tanggal_lupa', $this->tahun);
        }
        if ($this->search) {
            $query->where('pegawai.nama', 'like', '%'.$this->search.'%');
        }

        $results = $query->get()->pluck('total', 'jenis_absen')->toArray();

        return [
            'masuk' => $results['tidak mengisi absensi masuk'] ?? 0,
            'pulang' => $results['tidak mengisi absensi pulang'] ?? 0,
            'keduanya' => $results['tidak mengisi absensi masuk dan pulang'] ?? 0,
        ];
    }

    public function exportExcel(): StreamedResponse
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=rekap-bulanan-'.$this->bulan.'-'.$this->tahun.'.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['No', 'Nama Pegawai', 'NIP', 'Total Lupa Absen Datang (Masuk)', 'Total Lupa Absen Pulang', 'Total Frekuensi']);

            $data = $this->getPegawaiData();
            foreach ($data as $index => $row) {
                fputcsv($file, [
                    $index + 1,
                    $row['nama'],
                    $row['nip'],
                    $row['total_masuk'],
                    $row['total_pulang'],
                    $row['total_frekuensi'],
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf()
    {
        // Handled via client side window.print() inside extraAttributes.
    }
}
