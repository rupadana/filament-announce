<?php

namespace Rupadana\FilamentAnnounce;

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
use Rupadana\FilamentAnnounce\Commands\FilamentAnnounceCommand;
use Rupadana\FilamentAnnounce\Components\DashboardNotification;
use Rupadana\FilamentAnnounce\Testing\TestsFilamentAnnounce;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
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
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('rupadana/filament-announce');
            })
            ->hasViews('filament-announce');

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

        $this->app->singleton(FilamentAnnounce::class, function () {
            return new FilamentAnnounce();
        });

    }

    public function packageBooted(): void
    {
        Livewire::component('filament-announce', DashboardNotification::class);

        FilamentView::registerRenderHook(
            'panels::body.start',
            fn (): string => Blade::render('@livewire(\'filament-announce\')'),
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
                    $file->getRealPath() => base_path("stubs/filament-announce/{$file->getFilename()}"),
                ], 'filament-announce-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsFilamentAnnounce());
    }

    protected function getAssetPackageName(): ?string
    {
        return 'rupadana/filament-announce';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('filament-announce', __DIR__ . '/../resources/dist/components/filament-announce.js'),
            Css::make('filament-announce-styles', __DIR__ . '/../resources/dist/filament-announce.css'),
            // Js::make('filament-announce-scripts', __DIR__ . '/../resources/dist/filament-announce.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FilamentAnnounceCommand::class,
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
            'create_filament-announce_table',
        ];
    }
}
