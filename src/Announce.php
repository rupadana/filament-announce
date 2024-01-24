<?php

namespace Rupadana\FilamentAnnounce;

use Filament\Notifications\Notification;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Rupadana\FilamentAnnounce\Notifications\AnnounceNotification;

class Announce extends Notification
{
    protected bool $closeButton = true;

    public function announceTo(Model | Authenticatable | Collection | array $users): void
    {
        if (! $this->getColor()) {
            $this->color(app(FilamentAnnounce::class)->getColor());
        }

        if (! is_iterable($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {
            $notification = new AnnounceNotification($this->getDatabaseMessage());

            $user->notify($notification);
        }
    }

    public function disableCloseButton(bool $condition = true): static
    {
        $this->closeButton = ! $condition;

        return $this;
    }

    public function isCloseButton(): bool
    {
        return $this->closeButton;
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'closeButton' => $this->isCloseButton(),
        ];
    }
}
