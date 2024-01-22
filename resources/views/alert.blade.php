<div
@class([
    'bg-blue-600' => $status == 'info',
    'bg-red-600' => $status == 'danger',
    'bg-yellow-500' => $status == 'warning',
    'bg-green-500' => $status == 'success',
    'flex border border-transparent p-4',
])>
    @if ($icon)
        <div class="pr-3">
            <x-filament::icon icon="{{ $icon }}" class="h-5 w-5 " />
        </div>
    @endif
    <div @class([
        'relative w-full [&>svg]:absolute [&>svg]:text-foreground [&>svg]:left-4 [&>svg]:top-4 [&>svg+div]:translate-y-[-3px] text-white flex-1',
    ])>

        <h5 class="mb-1 font-medium leading-none tracking-tight">
            {{ $title }}
        </h5>
        <div class="text-sm opacity-80"> {{ $body }} </div>
    </div>


    <div>
        <x-filament::icon-button icon="heroicon-o-x-mark" color="white" x-on:click="$dispatch('markedNotificationDashboardAsRead', {id: '{{$modelId}}'})"/>
    </div>
</div>
