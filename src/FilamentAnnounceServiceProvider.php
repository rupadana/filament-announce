<?php

namespace Rupadana\FilamentAnnounce;

use Filament\Support\Facades\FilamentAsset;
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
            ->hasViews('filament-announce')
            ->hasConfigFile('filament-announce');

        if (app()->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

            $this->publishes([
                __DIR__ . '/Resources' => app_path('/Filament/Resources'),
            ], 'filament-announce-resource');
        }

    }

    public function packageRegistered(): void
    {
        $this->app->singleton(FilamentAnnounce::class, function () {
            return new FilamentAnnounce;
        });

        FilamentAsset::register($this->getAssets(), $this->getAssetPackageName());
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [];
    }

    protected function getAssetPackageName(): ?string
    {
        return 'rupadana/filament-announce';
    }
}
