@php
    use Filament\Support\Enums\Alignment;

    $titleAlignment = $notification->getTitleAlignment();
    $bodyAlignment = $notification->getBodyAlignment();
    $title = $notification->getTitle();
    $body = $notification->getBody();
    $actions = $notification->getActions();
    $color = $notification->getColor();

    if (! $titleAlignment instanceof Alignment) {
        $titleAlignment = filled($titleAlignment) ? (Alignment::tryFrom($titleAlignment) ?? $titleAlignment) : null;
    }

    if (! $bodyAlignment instanceof Alignment) {
        $bodyAlignment = filled($bodyAlignment) ? (Alignment::tryFrom($bodyAlignment) ?? $bodyAlignment) : null;
    }

    $colorClasses = \Illuminate\Support\Arr::toCssClasses(['flex items-center border border-transparent px-6 py-2 gap-4', 'bg-white text-gray-950 dark:bg-white/5 dark:text-white' => $color === 'gray', 'bg-custom-600 text-white dark:bg-custom-500' => $color !== 'gray']);

    $colorStyles = \Illuminate\Support\Arr::toCssStyles([
        \Filament\Support\get_color_css_variables($color, shades: [400, 500, 600]) => $color !== 'gray',
    ]);

    if (gettype($color) == 'string') {
        $colorStyles = "--c-400:$color;--c-500:$color;--c-600:$color;";
    }

@endphp

<div class="{{ $colorClasses }}" style="{{ $colorStyles }}">
    @if ($icon = $notification->getIcon())
        <div class="flex items-center">
            <x-filament::icon icon="{{ $icon }}" class="h-6 w-6" />
        </div>
    @endif
    <div @class([
        'w-full flex-1',
    ])>
        @if ($title && ! $body && $actions)
            <div @class([
                'flex flex-row flex-wrap items-center gap-4 leading-none',
                match ($titleAlignment) {
                    Alignment::Start, Alignment::Left => 'justify-start',
                    Alignment::Center => 'justify-center',
                    Alignment::End, Alignment::Right => 'justify-end',
                    Alignment::Between, Alignment::Justify => 'justify-between',
                    default => $titleAlignment,
                },
            ])>
                <h5 class="font-semibold">{{ $title }}</h5>

                <x-filament-notifications::actions :actions="$actions" class="flex-wrap gap-1" />
            </div>
        @elseif (! $title && $body && $actions)
            <div @class([
                'flex flex-row flex-wrap items-center gap-4 leading-none',
                match ($bodyAlignment) {
                    Alignment::Start, Alignment::Left => 'justify-start',
                    Alignment::Center => 'justify-center',
                    Alignment::End, Alignment::Right => 'justify-end',
                    Alignment::Between, Alignment::Justify => 'justify-between',
                    default => $bodyAlignment,
                },
            ])>
                <span class="text-sm">{{ $body }}</span>

                <x-filament-notifications::actions :actions="$actions" class="flex-wrap gap-1" />
            </div>
        @else
            <div @class([
                match ($titleAlignment) {
                    Alignment::Start => 'text-start',
                    Alignment::Center => 'text-center',
                    Alignment::End => 'text-end',
                    Alignment::Left => 'text-left',
                    Alignment::Right => 'text-right',
                    Alignment::Justify, Alignment::Between => 'text-justify',
                    default => $titleAlignment,
                },
            ])>
                <h5 class="font-semibold">{{ $title }}</h5>
            </div>
            <div @class([
                'flex flex-row flex-wrap items-center gap-4 leading-none',
                match ($bodyAlignment) {
                    Alignment::Start, Alignment::Left => 'justify-start',
                    Alignment::Center => 'justify-center',
                    Alignment::End, Alignment::Right => 'justify-end',
                    Alignment::Between, Alignment::Justify => 'justify-between',
                    default => $bodyAlignment,
                },
            ])>
                <span class="text-sm">{{ $body }}</span>

                @if ($actions)
                    <x-filament-notifications::actions :actions="$actions" class="flex-wrap gap-1" />
                @endif
            </div>
        @endif
    </div>


    @if ($notification->isClosable())
        <div class="flex items-center">
            <x-filament::icon-button icon="heroicon-o-x-mark" color="white"
                x-on:click="$dispatch('markedAnnouncementAsRead', {id: '{{ $notification->getId() }}'})" />
        </div>
    @endif
</div>
