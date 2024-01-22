<?php

namespace Rupadana\FilamentDashboardNotification;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Filament\Support\Facades\FilamentView;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Blade;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Rupadana\FilamentDashboardNotification\Commands\FilamentDashboardNotificationCommand;
use Rupadana\FilamentDashboardNotification\Components\Alert;
use Rupadana\FilamentDashboardNotification\Components\DashboardNotification;
use Rupadana\FilamentDashboardNotification\Components\DashboardNotificationWrapper;
use Rupadana\FilamentDashboardNotification\Testing\TestsFilamentDashboardNotification;

class FilamentDashboardNotificationServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-dashboard-notification';

    public static string $viewNamespace = 'filament-dashboard-notification';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('rupadana/filament-dashboard-notification');
            })
            ->hasViews('filament-dashboard-notification');

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void
    {

        $this->app->singleton(FilamentDashboardNotification::class, function () {
            return new FilamentDashboardNotification();
        });

        
    }

    public function packageBooted(): void
    {
        Livewire::component('filament-dashboard-notification', DashboardNotification::class);

        FilamentView::registerRenderHook(
            'panels::body.start',
            fn (): string => Blade::render('@livewire(\'filament-dashboard-notification\')'),
        );
        
        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/filament-dashboard-notification/{$file->getFilename()}"),
                ], 'filament-dashboard-notification-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentDashboardNotification());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'rupadana/filament-dashboard-notification';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-dashboard-notification', __DIR__ . '/../resources/dist/components/filament-dashboard-notification.js'),
            Css::make('filament-dashboard-notification-styles', __DIR__ . '/../resources/dist/filament-dashboard-notification.css'),
            // Js::make('filament-dashboard-notification-scripts', __DIR__ . '/../resources/dist/filament-dashboard-notification.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentDashboardNotificationCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_filament-dashboard-notification_table',
        ];
    }
}
