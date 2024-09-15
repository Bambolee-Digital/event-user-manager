<?php

namespace BamboleeDigital\EventUserManager\Filament\Resources\EventResource\Pages;

use BamboleeDigital\EventUserManager\Filament\Resources\EventResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListEvents extends ListRecords
{
    protected static string $resource = EventResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}