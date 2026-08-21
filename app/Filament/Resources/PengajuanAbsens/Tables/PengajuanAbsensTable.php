<?php

declare(strict_types=1);

namespace App\Filament\Resources\PengajuanAbsens\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuanAbsensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nomor_surat')
                    ->searchable()
                    ->label('Nomor Surat'),
                TextColumn::make('pegawai.nama')
                    ->searchable()
                    ->sortable()
                    ->label('Pegawai'),
                TextColumn::make('atasan.nama')
                    ->label('Atasan'),
                TextColumn::make('jenis_absen')
                    ->label('Jenis Absen'),
                TextColumn::make('tanggal_lupa')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal Lupa'),
                TextColumn::make('tanggal_pengajuan')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal Pengajuan'),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'disetujui' => 'success',
                        'ditolak' => 'danger',
                        default => 'warning',
                    })
                    ->label('Status'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'disetujui' => 'Disetujui',
                        'ditolak' => 'Ditolak',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
