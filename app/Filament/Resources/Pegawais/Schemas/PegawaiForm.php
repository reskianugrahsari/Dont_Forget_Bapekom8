<?php

declare(strict_types=1);

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Schemas\Components\Select;
use Filament\Schemas\Components\TextInput;
use Filament\Schemas\Schema;

class PegawaiForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nip')
                    ->required()
                    ->unique(ignorable: fn ($record) => $record)
                    ->maxLength(50)
                    ->label('NIP'),
                TextInput::make('nama')
                    ->required()
                    ->maxLength(150)
                    ->label('Nama Pegawai'),
                TextInput::make('pangkat_gol')
                    ->required()
                    ->maxLength(50)
                    ->label('Pangkat / Golongan'),
                TextInput::make('jabatan')
                    ->required()
                    ->maxLength(100)
                    ->label('Jabatan'),
                TextInput::make('bagian')
                    ->required()
                    ->maxLength(100)
                    ->label('Bagian'),
                Select::make('atasan_id')
                    ->relationship('atasan', 'nama')
                    ->searchable()
                    ->preload()
                    ->nullable()
                    ->label('Atasan Langsung'),
            ]);
    }
}
