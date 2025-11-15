<?php

namespace App\Filament\Resources\TimeChangeRequestResource\Pages;

use App\Filament\Resources\TimeChangeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimeChangeRequest extends EditRecord
{
    protected static string $resource = TimeChangeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
