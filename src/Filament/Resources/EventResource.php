<?php

namespace BamboleeDigital\EventUserManager\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Repeater;
use BamboleeDigital\EventUserManager\Models\Event;
use BamboleeDigital\EventUserManager\Filament\Resources\EventResource\Pages;

class EventResource extends Resource
{
    protected static ?string $model = null;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    public static function getModel(): string
    {
        return config('event-user-manager.models.event', Event::class);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('event_type_id')
                    ->relationship('eventType', 'name')
                    ->required(),
                Forms\Components\Select::make('recurrence_pattern_id')
                    ->relationship('recurrencePattern', 'name'),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->required(),
                Forms\Components\DateTimePicker::make('end_date'),
                Forms\Components\Grid::make(['default' => 2])
                    ->schema([
                        Forms\Components\TextInput::make('duration_hours')
                            ->numeric()
                            ->minValue(0)
                            ->label('Duration (Hours)'),
                        Forms\Components\TextInput::make('duration_minutes')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(59)
                            ->label('Duration (Minutes)'),
                    ]),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'active' => 'Active',
                        'past' => 'Past',
                        'cancelled' => 'Cancelled',
                        'pending' => 'Pending',
                        'rescheduled' => 'Rescheduled',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('frequency_count')
                    ->numeric()
                    ->minValue(1),
                    Forms\Components\Select::make('frequency_type')
                    ->options([
                        'minute' => 'Minute',
                        'hourly' => 'Hourly',
                        'daily' => 'Daily',
                        'weekly' => 'Weekly',
                        'monthly' => 'Monthly',
                        'yearly' => 'Yearly',
                    ]),
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->directory('event-attachments'),
                Forms\Components\FileUpload::make('images')
                    ->image()
                    ->multiple()
                    ->directory('event-images'),
                Repeater::make('metadata')
                    ->schema([
                        Forms\Components\TextInput::make('key')->required(),
                        Forms\Components\TextInput::make('value')->required(),
                    ])
                    ->columns(2),
                Repeater::make('notes')
                    ->relationship('notes')
                    ->schema([
                        Forms\Components\Textarea::make('content')->required(),
                        Forms\Components\FileUpload::make('attachments')
                            ->multiple()
                            ->directory('note-attachments'),
                        Forms\Components\FileUpload::make('images')
                            ->image()
                            ->multiple()
                            ->directory('note-images'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('eventType.name'),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('duration')
                    ->formatStateUsing(fn ($record) => sprintf('%02d:%02d', $record->duration_hours, $record->duration_minutes)),
                Tables\Columns\TextColumn::make('status'),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return config('event-user-manager.filament.navigation_group', 'Event Management');
    }
}