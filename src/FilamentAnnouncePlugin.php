<?php

namespace Rupadana\FilamentAnnounce;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Rupadana\FilamentAnnounce\Components\Announcement;
use Rupadana\FilamentAnnounce\Resources\AnnouncementResource;

class FilamentAnnouncePlugin implements Plugin
{
    protected string $resource = AnnouncementResource::class;

    public function getId(): string
    {
        return 'filament-announce';
    }

    public function usingResource(string $resource): static
    {
        $this->resource = $resource;

        return $this;
    }

    public function register(Panel $panel): void
    {
        $panel
            ->renderHook(
                PanelsRenderHook::BODY_START,
                fn (): string => Blade::render('@livewire(\'filament-announce\')'),
            )
            ->resources([
                $this->resource,
            ]);
    }

    public function boot(Panel $panel): void
    {
        Livewire::component('filament-announce', Announcement::class);
    }

    public static function make(): static
    {
        return app(static::class)
            ->defaultColor('primary');
    }

    public function pollingInterval(?string $interval)
    {
        app(FilamentAnnounce::class)->pollingInterval($interval);

        return $this;
    }

    public function defaultColor(string | array | Closure | null $color)
    {
        app(FilamentAnnounce::class)->color($color);

        return $this;
    }
}
