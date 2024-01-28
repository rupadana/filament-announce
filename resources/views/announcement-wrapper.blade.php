<div
    @if ($pollingInterval = $this->getPollingInterval())
        wire:poll.{{ $pollingInterval }}
    @endif
>
    @foreach ($this->getUnreadNotificationsData() as $item)
        {{-- todo: use blade component instead of @include --}}
        @include('filament-announce::announcement', [
            'notification' => $this->getNotification($item),
        ])
    @endforeach
</div>
