<?php

namespace Rupadana\FilamentAnnounce\Resources\AnnouncementResource\Pages;

use Filament\Resources\Pages\ViewRecord;
use Rupadana\FilamentAnnounce\Resources\AnnouncementResource;

class ViewAnnouncement extends ViewRecord
{
    protected static string $resource = AnnouncementResource::class;

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
