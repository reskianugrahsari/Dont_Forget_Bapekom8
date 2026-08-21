<?php

declare(strict_types=1);

namespace App\Filament\Resources\Pegawais\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PegawaisTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nip')
                    ->searchable()
                    ->sortable()
                    ->label('NIP'),
                TextColumn::make('nama')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                TextColumn::make('pangkat_gol')
                    ->label('Pangkat/Gol'),
                TextColumn::make('jabatan')
                    ->searchable()
                    ->label('Jabatan'),
                TextColumn::make('bagian')
                    ->searchable()
                    ->label('Bagian'),
                TextColumn::make('atasan.nama')
                    ->label('Atasan Langsung'),
            ])
            ->filters([
                //
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
