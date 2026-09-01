<?php

declare(strict_types=1);

namespace App\Filament\Resources\PengajuanAbsens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PengajuanAbsenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('pegawai_id')
                    ->relationship('pegawai', 'nama')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nama} - {$record->jabatan}")
                    ->searchable(['nama', 'jabatan'])
                    ->preload()
                    ->required()
                    ->label('Pegawai (Pemohon)'),
                Select::make('atasan_id')
                    ->relationship(
                        'atasan',
                        'nama',
                        fn ($query) => $query->whereIn('jabatan', ['Kepala Balai', 'Kepala Subbag Umum dan Tata Usaha', 'Kepala Seksi Penyelenggaraan'])
                            ->orWhereIn('nama', ['Widyanto Hendro Saputro, ST, M.Si', 'Wahyuni A, ST, MT', 'Sarnaeni B,SP,M.T'])
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->nama} - {$record->jabatan}")
                    ->searchable(['nama', 'jabatan'])
                    ->preload()
                    ->required()
                    ->label('Atasan Penandatangan'),
                Select::make('jenis_absen')
                    ->options([
                        'tidak mengisi absensi masuk' => 'Tidak mengisi absensi masuk',
                        'tidak mengisi absensi pulang' => 'Tidak mengisi absensi pulang',
                    ])
                    ->required()
                    ->label('Jenis Lupa Absen'),
                Textarea::make('alasan')
                    ->required()
                    ->label('Alasan'),
                DatePicker::make('tanggal_lupa')
                    ->required()
                    ->label('Tanggal Lupa Absen'),
                DatePicker::make('tanggal_pengajuan')
                    ->default(now())
                    ->required()
                    ->label('Tanggal Pengajuan'),
                TextInput::make('kota_surat')
                    ->default('Makassar')
                    ->required()
                    ->maxLength(50)
                    ->label('Kota Surat'),
                Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ])
                    ->default('pending')
                    ->required()
                    ->label('Status'),
            ]);
    }
}
