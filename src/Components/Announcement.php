<?php

namespace Rupadana\FilamentAnnounce\Components;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Livewire\Attributes\On;
use Livewire\Component;
use Rupadana\FilamentAnnounce\Announce;
use Rupadana\FilamentAnnounce\FilamentAnnounce;
use Rupadana\FilamentAnnounce\Notifications\AnnounceNotification;

class Announcement extends Component
{
    public static ?string $authGuard = null;

    protected static string $view = 'filament-announce::announcement-wrapper';

    public function getUnreadNotificationsData()
    {
        if (! auth()->user()) {
            return [];
        }

        return $this->getUnreadNotificationsQuery()->get();
    }

    public function getNotification(DatabaseNotification $notification): Announce
    {
        return Announce::fromDatabase($notification);
    }

    #[On('markedAnnouncementAsRead')]
    public function markNotificationAsRead(string $id): void
    {
        $this->getNotificationsQuery()
            ->where('id', $id)
            ->update(['read_at' => now()]);
    }

    public function getNotifications(): DatabaseNotificationCollection
    {
        return $this->getNotificationsQuery()->get();
    }

    public function getNotificationsQuery(): Builder | Relation
    {
        /** @phpstan-ignore-next-line */
        return $this
            ->getUser()
            ->notifications()
            ->where('type', AnnounceNotification::class);
    }

    public function getUnreadNotificationsQuery(): Builder | Relation
    {
        /** @phpstan-ignore-next-line */
        return $this->getNotificationsQuery()->unread();
    }

    public function getUnreadNotificationsCount(): int
    {
        return $this->getUnreadNotificationsQuery()->count();
    }

    public function getPollingInterval(): ?string
    {
        return app(FilamentAnnounce::class)->getPollingInterval();
    }

    public function getUser(): Model | Authenticatable | null
    {
        return auth(static::$authGuard)->user();
    }

    public function render()
    {
        return static::$view;
    }
}
