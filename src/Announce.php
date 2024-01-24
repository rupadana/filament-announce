<?php

namespace Rupadana\FilamentAnnounce;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Rupadana\FilamentAnnounce\Notifications\AnnounceNotification;
use Illuminate\Support\Str;

class Announce extends Notification
{
    public function announceTo(Model | Authenticatable | Collection | array $users): void
    {
        if(!$this->getColor()) {
            $this->color(app(FilamentAnnounce::class)->getColor());
        }

        if (!is_iterable($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {
            $notification = new AnnounceNotification($this->getDatabaseMessage());

            $user->notify($notification);
        }
    }
}
