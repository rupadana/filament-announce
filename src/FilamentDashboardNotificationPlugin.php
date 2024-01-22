<?php

namespace Rupadana\FilamentDashboardNotification;


use Filament\Contracts\Plugin;
use Filament\Panel;
use Rupadana\FilamentDashboardNotification\Widgets\DashboardNotificationWidget;

class FilamentDashboardNotificationPlugin implements Plugin
{
    public function getId(): string
    {
        return 'filament-dashboard-notification';
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

    public function pollingInterval(?string $interval) {
        app(FilamentDashboardNotification::class)->pollingInterval($interval);

        return $this;
    }
}
