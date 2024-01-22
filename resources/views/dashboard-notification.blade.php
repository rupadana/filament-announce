@php
    $unreadNotifications = $this->getUnreadNotificationsQuery()->get();
    $pollingInterval = $this->getPollingInterval();
@endphp

<div wire:poll.{{$pollingInterval}}>
    <div class="grid gap-2 grid-cols-1">
        @foreach ($unreadNotifications as $notification)
            @include(
                'filament-dashboard-notification::alert',
                array_merge($notification->data, [
                    'modelId' => $notification->id,
                ]))
        @endforeach
    </div>
</div>
