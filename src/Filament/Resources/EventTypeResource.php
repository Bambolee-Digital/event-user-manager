<?php

namespace BamboleeDigital\EventUserManager\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use BamboleeDigital\EventUserManager\Models\EventType;
use BamboleeDigital\EventUserManager\Filament\Resources\EventTypeResource\Pages\EditEventType;
use BamboleeDigital\EventUserManager\Filament\Resources\EventTypeResource\Pages\ListEventTypes;
use BamboleeDigital\EventUserManager\Filament\Resources\EventTypeResource\Pages\CreateEventType;

class EventTypeResource extends Resource
{
    protected static ?string $model = EventType::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function getModel(): string
    {
        return config('event-user-manager.models.event_type', EventType::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)->schema([

                    FileUpload::make('icon')
                        ->image()
                        ->columnSpanFull(),

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

                    Forms\Components\Toggle::make('is_custom')
                        ->reactive(),

                    Select::make('user_id')
                        ->relationship('user', 'name')
                        ->nullable()
                        ->visible(fn($get) => $get('is_custom')),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\ImageColumn::make('icon'),
                Tables\Columns\IconColumn::make('is_custom')
                    ->boolean(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Custom For'),
            ])
            ->filters([
                Tables\Filters\Filter::make('custom')
                    ->query(fn($query) => $query->where('is_custom', true)),
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
            'index' => ListEventTypes::route('/'),
            'create' => CreateEventType::route('/create'),
            'edit' => EditEventType::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return config('event-user-manager.filament.navigation_group', 'Event Management');
    }
}
