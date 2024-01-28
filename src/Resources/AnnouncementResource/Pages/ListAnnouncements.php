<?php

namespace Rupadana\FilamentAnnounce\Resources\AnnouncementResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Rupadana\FilamentAnnounce\Resources\AnnouncementResource;

class ListAnnouncements extends ListRecords
{
    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
