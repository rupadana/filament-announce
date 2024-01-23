<?php

namespace Rupadana\FilamentAnnounce;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FilamentAnnouncePlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-announce';
    }

    public function register(Panel $panel): void
    {
    }

    public function boot(Panel $panel): void
    {
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }

    public function pollingInterval(?string $interval)
    {
        app(FilamentAnnounce::class)->pollingInterval($interval);

        return $this;
    }
}
