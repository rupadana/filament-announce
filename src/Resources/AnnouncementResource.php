<?php

namespace Rupadana\FilamentAnnounce\Resources;

use App\Models\User;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;
use Guava\FilamentIconPicker\Tables\IconColumn;
use Rupadana\FilamentAnnounce\Models\Announcement;
use Rupadana\FilamentAnnounce\Resources\AnnouncementResource\Pages;

class AnnouncementResource extends Resource
{
    protected static ?string $model = Announcement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->minLength(5)
                            ->required(),
                        TextInput::make('title')
                            ->minLength(5)
                            ->required(),
                        Textarea::make('body')
                            ->minLength(20)
                            ->required(),
                        IconPicker::make('icon'),
                        Select::make('color')
                            ->options([
                                ...collect(FilamentColor::getColors())->map(fn($value, $key) => ucfirst($key))->toArray(),
                                'custom' => 'Custom',
                            ])
                            ->live(),
                        ColorPicker::make('custom_color')
                            ->hidden(fn(Get $get) => $get('color') != 'custom')
                            ->requiredIf('color', 'custom')
                            ->rgb(),

                        Select::make('users')
                            ->options(User::pluck('name', 'id')->toArray())
                            ->hidden(fn(Get $get) => $get('all_users'))
                            ->multiple()
                            ->required(),
                    ])->columns(2),

                Toggle::make('all_users')
                    ->live()
                    ->label('All users')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('title'),
                TextColumn::make('body'),
                IconColumn::make('icon'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnnouncements::route('/'),
            'create' => Pages\CreateAnnouncement::route('/create'),
            'view' => Pages\ViewAnnouncement::route('/{record}'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return config('filament-announce.navigation.group');
    }

    public static function canAccess(): bool
    {
        if (method_exists(auth()->user(), 'hasRole')) {
            return auth()->user()->hasRole(config('filament-announce.can_access.role') ?? []);
        }

        return true;
    }

    public static function getNavigationSort(): ?int
    {
        return config('filament-announce.navigation.sort') ?? -1;
    }
}
