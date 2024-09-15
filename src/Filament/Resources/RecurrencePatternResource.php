<?php

namespace BamboleeDigital\EventUserManager\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use BamboleeDigital\EventUserManager\Models\RecurrencePattern;
use BamboleeDigital\EventUserManager\Filament\Resources\RecurrencePatternResource\Pages\EditRecurrencePattern;
use BamboleeDigital\EventUserManager\Filament\Resources\RecurrencePatternResource\Pages\ListRecurrencePatterns;
use BamboleeDigital\EventUserManager\Filament\Resources\RecurrencePatternResource\Pages\CreateRecurrencePattern;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class RecurrencePatternResource extends Resource
{
    protected static ?string $model = null;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function getModel(): string
    {
        return config('event-user-manager.models.recurrence_pattern', RecurrencePattern::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // add tabs for name of language and the translation array supportad_locale from config tabs
                Tabs::make('Translations')
                    ->tabs(
                        collect(config('event-user-manager.supported_locales', ['en']))
                            ->map(function ($locale) {
                                return Tab::make(strtoupper($locale))
                                    ->schema([
                                        Forms\Components\TextInput::make('name.' . $locale)
                                            ->label('Name')
                                            ->required(),
                                    ]);
                            })
                            ->toArray()
                    ),
                
                Forms\Components\Select::make('frequency_type')
                    ->options([
                        'minute' => 'Minute',
                        'hourly' => 'Hourly',
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('interval')
                    ->numeric()
                    ->minValue(1)
                    ->required(),
                Forms\Components\CheckboxList::make('days')
                    ->options([
                        'monday' => 'Monday',
                        'tuesday' => 'Tuesday',
                        'wednesday' => 'Wednesday',
                        'thursday' => 'Thursday',
                        'friday' => 'Friday',
                        'saturday' => 'Saturday',
                        'sunday' => 'Sunday',
                    ])
                    ->columns(4)
                    ->visible(fn (Forms\Get $get) => $get('frequency_type') === 'weekly'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('frequency_type'),
                Tables\Columns\TextColumn::make('interval'),
                Tables\Columns\TextColumn::make('days')
                    ->formatStateUsing(fn ($state) => implode(', ', $state ?? [])),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
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
            'index' => ListRecurrencePatterns::route('/'),
            'create' => CreateRecurrencePattern::route('/create'),
            'edit' => EditRecurrencePattern::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return config('event-user-manager.filament.navigation_group', 'Event Management');
    }
}