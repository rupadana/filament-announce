# Filament Dashboard Notification

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rupadana/filament-announce.svg?style=flat-square)](https://packagist.org/packages/rupadana/filament-announce)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/rupadana/filament-announce/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/rupadana/filament-announce/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rupadana/filament-announce.svg?style=flat-square)](https://packagist.org/packages/rupadana/filament-announce)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/rupadana/filament-announce/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/rupadana/filament-announce/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require rupadana/filament-announce
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-dashboard-notification-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage
You must enable Announce by adding the class to your Filament Panel's plugin() or plugins([]) method:

```php
use Rupadana\FilamentAnnounce\FilamentAnnouncePlugin;

class CustomersPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugin(
                FilamentAnnouncePlugin::make()
                    ->pollingInterval(30) // optional, by default the polling interval is set to null
            )
    }
}

```

Now you can announce whatever to users:

```php
use App\Models\User;
use Rupadana\FilamentAnnounce\Announce;

Announce::make()
    ->title('Big News!')
    ->icon('heroicon-o-megaphone')
    ->body('Filament can now show very important message to specific users!')
    ->announceTo(User::all());
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rupadana](https://github.com/rupadana)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
