<?php

namespace App\Filament\Resources\PengajuanAbsens;

use App\Filament\Resources\PengajuanAbsens\Pages\CreatePengajuanAbsen;
use App\Filament\Resources\PengajuanAbsens\Pages\EditPengajuanAbsen;
use App\Filament\Resources\PengajuanAbsens\Pages\ListPengajuanAbsens;
use App\Filament\Resources\PengajuanAbsens\Schemas\PengajuanAbsenForm;
use App\Filament\Resources\PengajuanAbsens\Tables\PengajuanAbsensTable;
use App\Models\PengajuanAbsen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PengajuanAbsenResource extends Resource
{
    protected static ?string $model = PengajuanAbsen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'tanggal_pengajuan';

    public static function form(Schema $schema): Schema
    {
        return PengajuanAbsenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajuanAbsensTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPengajuanAbsens::route('/'),
            'create' => CreatePengajuanAbsen::route('/create'),
            'edit' => EditPengajuanAbsen::route('/{record}/edit'),
        ];
    }
}
