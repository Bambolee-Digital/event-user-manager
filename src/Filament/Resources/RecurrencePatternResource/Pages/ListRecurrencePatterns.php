<?php

namespace BamboleeDigital\EventUserManager\Filament\Resources\RecurrencePatternResource\Pages;

use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use BamboleeDigital\EventUserManager\Filament\Resources\RecurrencePatternResource;

class ListRecurrencePatterns extends ListRecords
{
    protected static string $resource = RecurrencePatternResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}