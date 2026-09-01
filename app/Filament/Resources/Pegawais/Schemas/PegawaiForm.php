<?php

declare(strict_types=1);

namespace App\Filament\Resources\Pegawais\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                Select::make('bagian')
                    ->options([
                        'Penyelenggara' => 'Penyelenggara',
                        'Tata Usaha' => 'Tata Usaha',
                    ])
                    ->required()
                    ->label('Bagian'),
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
                    ->nullable()
                    ->label('Atasan Langsung'),
            ]);
    }
}
