<?php

namespace Rupadana\FilamentAnnounce;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentAnnounceServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-announce';

    public static string $viewNamespace = 'filament-announce';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews('filament-announce');
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(FilamentAnnounce::class, function () {
            return new FilamentAnnounce;
        });
    }
}
