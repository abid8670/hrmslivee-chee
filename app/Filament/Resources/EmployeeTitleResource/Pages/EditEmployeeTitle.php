<?php

namespace App\Filament\Resources\EmployeeTitleResource\Pages;

use App\Filament\Resources\EmployeeTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEmployeeTitle extends EditRecord
{
    protected static string $resource = EmployeeTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
