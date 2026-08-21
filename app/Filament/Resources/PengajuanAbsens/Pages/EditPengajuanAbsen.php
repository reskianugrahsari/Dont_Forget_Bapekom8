<?php

namespace App\Filament\Resources\PengajuanAbsens\Pages;

use App\Filament\Resources\PengajuanAbsens\PengajuanAbsenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanAbsen extends EditRecord
{
    protected static string $resource = PengajuanAbsenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
