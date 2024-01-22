<?php

namespace Rupadana\FilamentDashboardNotification\Components;

use Carbon\CarbonInterface;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use Rupadana\FilamentDashboardNotification\FilamentDashboardNotification;

class DashboardNotification extends Component
{

    public static ?string $authGuard = null;
    
    protected static string $view = 'filament-dashboard-notification::dashboard-notification';

    protected int | string | array $columnSpan = 2;

    protected static ?int $sort = -20;

    public function getUnreadNotificationsData() {
        return $this->getUnreadNotificationsQuery()->get();
    }

    #[On('databaseNotificationsSent')]
    public function refresh(): void
    {
    }

    #[On('notificationClosed')]
    public function removeNotification(string $id): void
    {
        $this->getNotificationsQuery()
            ->where('id', $id)
            ->delete();
    }

    #[On('markedNotificationDashboardAsRead')]
    public function markNotificationAsRead(string $id): void
    {
        // dd($id);
        $this->getNotificationsQuery()
            ->where('id', $id)
            ->update(['read_at' => now()]);
    }

    #[On('markedNotificationAsUnread')]
    public function markNotificationAsUnread(string $id): void
    {
        $this->getNotificationsQuery()
            ->where('id', $id)
            ->update(['read_at' => null]);
    }

    public function clearNotifications(): void
    {
        $this->getNotificationsQuery()->delete();
    }

    public function markAllNotificationsAsRead(): void
    {
        $this->getUnreadNotificationsQuery()->update(['read_at' => now()]);
    }

    public function getNotifications(): DatabaseNotificationCollection | Paginator
    {
        if (!$this->isPaginated()) {
            /** @phpstan-ignore-next-line */
            return $this->getNotificationsQuery()->get();
        }

        return $this->getNotificationsQuery()->simplePaginate(50);
    }

    // public function isPaginated(): bool
    // {
    //     return static::$isPaginated;
    // }

    public function getNotificationsQuery(): Builder | Relation
    {
        /** @phpstan-ignore-next-line */
        return $this->getUser()->notifications()->where('data->format', 'filament');
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

    // public function getPollingInterval(): ?string
    // {
    //     return static::$pollingInterval;
    // }

    // public function getTrigger(): ?View
    // {
    //     $viewPath = static::$trigger;

    //     if (blank($viewPath)) {
    //         return null;
    //     }

    //     return view($viewPath);
    // }

    public function getUser(): Model | Authenticatable | null
    {
        return auth(static::$authGuard)->user();
    }

    public function getBroadcastChannel(): ?string
    {
        $user = $this->getUser();

        if (!$user) {
            return null;
        }

        if (method_exists($user, 'receivesBroadcastNotificationsOn')) {
            return $user->receivesBroadcastNotificationsOn();
        }

        $userClass = str_replace('\\', '.', $user::class);

        return "{$userClass}.{$user->getKey()}";
    }

    public function getNotification(DatabaseNotification $notification): Notification
    {
        return Notification::fromDatabase($notification)
            ->date($this->formatNotificationDate($notification->getAttributeValue('created_at')));
    }

    protected function formatNotificationDate(CarbonInterface $date): string
    {
        return $date->diffForHumans();
    }

    
    /**
     * @return array<string>
     */
    public function queryStringHandlesPagination(): array
    {
        return [];
    }

    public function render() {
        return static::$view;
    }

    /**
     * Get the value of pollingInterval
     */ 
    public function getPollingInterval()
    {
        return app(FilamentDashboardNotification::class)->getPollingInterval();
    }

}
