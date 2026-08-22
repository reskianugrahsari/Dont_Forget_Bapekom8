<?php

namespace App\Filament\Resources\Pegawais\RelationManagers;

use App\Filament\Resources\PengajuanAbsens\Schemas\PengajuanAbsenForm;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PengajuanRelationManager extends RelationManager
{
    protected static string $relationship = 'pengajuan';

    protected static ?string $title = 'Riwayat Surat Lupa Absen';

    public function form(Schema $schema): Schema
    {
        return PengajuanAbsenForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('tanggal_pengajuan')
            ->columns([
                TextColumn::make('nomor_surat')
                    ->searchable()
                    ->label('Nomor Surat'),
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
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
