@php
    $unreadNotifications = $this->getUnreadNotificationsQuery()->get();
    $pollingInterval = $this->getPollingInterval();
@endphp

<div
    @if ($pollingInterval = $this->getPollingInterval())
        wire:poll.{{ $pollingInterval }}
    @endif
>
    <div class="flex flex-col">
        @foreach ($unreadNotifications as $notification)
            @include('filament-announce::announcement')
        @endforeach
    </div>
</div>
