@php
    $unreadNotifications = $this->getUnreadNotificationsData();
    $pollingInterval = $this->getPollingInterval();
@endphp

<div
    @if ($pollingInterval)
        wire:poll.{{ $pollingInterval }}
    @endif
>
    <div class="flex flex-col">
        @foreach ($unreadNotifications as $notification)
            @include('filament-announce::announcement')
        @endforeach
    </div>
</div>
