<?php

namespace Rupadana\FilamentAnnounce;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;
use Rupadana\FilamentAnnounce\Components\Announcement;

class FilamentAnnouncePlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-announce';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->renderHook(
                'panels::body.start',
                fn (): string => Blade::render('@livewire(\'filament-announce\')'),
            )
            ->assets(
                $this->getAssets(),
                $this->getAssetPackageName(),
            );
    }

    public function boot(Panel $panel): void
    {
        Livewire::component('filament-announce', Announcement::class);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function pollingInterval(?string $interval)
    {
        app(FilamentAnnounce::class)->pollingInterval($interval);

        return $this;
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            Css::make('filament-announce-styles', __DIR__ . '/../resources/dist/filament-announce.css'),
        ];
    }

    protected function getAssetPackageName(): ?string
    {
        return 'rupadana/filament-announce';
    }
}
