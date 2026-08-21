<?php

namespace App\Filament\Resources\PengajuanAbsens\Pages;

use App\Filament\Resources\PengajuanAbsens\PengajuanAbsenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanAbsens extends ListRecords
{
    protected static string $resource = PengajuanAbsenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
