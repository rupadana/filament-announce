@php
    $data = $notification->data;

    $color = $data['color'] ?? $data['iconColor'] ?? $data['status'];
    $icon = $data['icon'];
    $title = $data['title'];
    $body = $data['body'];

    $colorClasses = \Illuminate\Support\Arr::toCssClasses([
        'flex items-center border border-transparent px-6 py-1 gap-4',
        'bg-white text-gray-950 dark:bg-white/5 dark:text-white' => $color === 'gray',
        'bg-custom-600 text-white dark:bg-custom-500' => $color !== 'gray',
    ]);

    $colorStyles = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables(
            $color,
            shades: [400, 500, 600],
        ) => $color !== 'gray',
    ]);
@endphp

<div class="{{ $colorClasses }}" style="{{ $colorStyles }}">
    @if ($icon)
        <div class="flex items-center">
            <x-filament::icon icon="{{ $icon }}" class="h-8 w-8" />
        </div>
    @endif
    <div @class([
        'w-full [&>svg]:absolute [&>svg]:text-foreground [&>svg]:left-4 [&>svg]:top-4 [&>svg+div]:translate-y-[-3px] text-white flex-1',
    ])>

        <h5 class="font-semibold leading-none tracking-tight">
            {{ $title }}
        </h5>
        <div class="text-sm">
            {{ $body }}
        </div>
    </div>


    <div class="flex items-center">
        <x-filament::icon-button icon="heroicon-o-x-mark" color="white" x-on:click="$dispatch('markedAnnouncementAsRead', {id: '{{ $notification->id }}'})"/>
    </div>
</div>
