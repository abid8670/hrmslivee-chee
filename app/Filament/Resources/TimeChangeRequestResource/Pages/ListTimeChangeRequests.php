<?php

namespace App\Filament\Resources\TimeChangeRequestResource\Pages;

use App\Filament\Resources\TimeChangeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimeChangeRequests extends ListRecords
{
    protected static string $resource = TimeChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
