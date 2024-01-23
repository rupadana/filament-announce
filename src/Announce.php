<?php

namespace Rupadana\FilamentAnnounce;

use Filament\Notifications\Concerns;
use Filament\Notifications\Notification;
use Filament\Support\Concerns\HasColor;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Rupadana\FilamentAnnounce\Notifications\AnnounceNotification;

class Announce
{
    use Concerns\HasActions;
    use Concerns\HasBody;
    use Concerns\HasIcon;
    use Concerns\HasTitle;
    use HasColor;

    public static function make()
    {
        return new static;
    }

    public function announceTo(Model | Authenticatable | Collection | array $users): void
    {
        $announcement = Notification::make()
            ->title($this->title)
            ->body($this->body)
            ->icon($this->icon)
            ->color($this->color);

        if (! is_iterable($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {
            $notification = new AnnounceNotification($announcement->getDatabaseMessage());

            $user->notify($notification);
        }
    }
}
