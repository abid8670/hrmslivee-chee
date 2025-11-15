<?php

namespace App\Filament\Resources\EmployeeTitleResource\Pages;

use App\Filament\Resources\EmployeeTitleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEmployeeTitles extends ListRecords
{
    protected static string $resource = EmployeeTitleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
