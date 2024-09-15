<?php

namespace BamboleeDigital\EventUserManager\Filament\Resources\EventTypeResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use BamboleeDigital\EventUserManager\Filament\Resources\EventTypeResource;

class ListEventTypes extends ListRecords
{
    protected static string $resource = EventTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}