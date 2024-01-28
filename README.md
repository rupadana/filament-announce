# Filament Announce

[![Latest Version on Packagist](https://img.shields.io/packagist/v/rupadana/filament-announce.svg?style=flat-square)](https://packagist.org/packages/rupadana/filament-announce)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/rupadana/filament-announce/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/rupadana/filament-announce/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/rupadana/filament-announce.svg?style=flat-square)](https://packagist.org/packages/rupadana/filament-announce)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/rupadana/filament-announce/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/rupadana/filament-announce/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)



An easy way to shout your exceptional offerings to the potential users 🤑... Or some serious pressure to bad employees 😡

![](https://res.cloudinary.com/rupadana/image/upload/v1706100163/Screenshot_2024-01-24_at_20.14.43_focxhf.png)

## Installation

You can install the package via composer:

```bash
composer require rupadana/filament-announce
```


```bash
php artisan migrate
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-announce-views"
```

publish config

```bash
php artisan vendor:publish --tag="filament-announce-config"
```

```php
return [
    'navigation' => [
        'group' => '',
    ],
    'can_access' => [
        'role' => ['super_admin']
    ]
];
```


## Usage
You must enable Announce by adding the class to your Filament Panel's plugin() or plugins([]) method:

```php
use Rupadana\FilamentAnnounce\FilamentAnnouncePlugin;
use Filament\Support\Colors\Color;
class CustomersPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ...
            ->plugin(
                FilamentAnnouncePlugin::make()
                    ->pollingInterval('30s') // optional, by default it is set to null
                    ->defaultColor(Color::Blue) // optional, by default it is set to "primary"

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
    ->disableCloseButton() // Optional, if you want ur announcement discloseable
    ->announceTo(User::all());
```


## Add an action to announce

![](https://private-user-images.githubusercontent.com/26832856/300244433-61677a79-9706-41c4-be86-19173484f943.png?jwt=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJnaXRodWIuY29tIiwiYXVkIjoicmF3LmdpdGh1YnVzZXJjb250ZW50LmNvbSIsImtleSI6ImtleTUiLCJleHAiOjE3MDY0Mzc3MzEsIm5iZiI6MTcwNjQzNzQzMSwicGF0aCI6Ii8yNjgzMjg1Ni8zMDAyNDQ0MzMtNjE2NzdhNzktOTcwNi00MWM0LWJlODYtMTkxNzM0ODRmOTQzLnBuZz9YLUFtei1BbGdvcml0aG09QVdTNC1ITUFDLVNIQTI1NiZYLUFtei1DcmVkZW50aWFsPUFLSUFWQ09EWUxTQTUzUFFLNFpBJTJGMjAyNDAxMjglMkZ1cy1lYXN0LTElMkZzMyUyRmF3czRfcmVxdWVzdCZYLUFtei1EYXRlPTIwMjQwMTI4VDEwMjM1MVomWC1BbXotRXhwaXJlcz0zMDAmWC1BbXotU2lnbmF0dXJlPWU2NTRjZjIyYjA3NjcwMDExODJjZTJjYzQwMTVmMDU2OTk4YWM0N2EyMWY4MjI1MjA4MmNmZmQzNTE2NWU2ZjImWC1BbXotU2lnbmVkSGVhZGVycz1ob3N0JmFjdG9yX2lkPTAma2V5X2lkPTAmcmVwb19pZD0wIn0.x16B1wDTY2klrlWWdeWo6LK3O82E3_3i89uetbiRYl4)

cause of Announce is extend of Announce, you can use Filament Notification Action

```php
use App\Models\User;
use Rupadana\FilamentAnnounce\Announce;

Announce::make()
    ->title('Big News!')
    ->icon('heroicon-o-megaphone')
    ->body('Filament can now show very important message to specific users!')
    ->actions([
        Action::make('view')
            ->button(),
        Action::make('undo')
            ->color('gray'),
    ])
    ->announceTo(User::all());
```

Read more about [Notification Action](https://filamentphp.com/docs/3.x/notifications/sending-notifications#adding-actions-to-notifications).

## Announcement Resource

![](https://github.com/rupadana/filament-announce/assets/34137674/af4e43a3-0093-49ab-b493-504d7607fb2b)


## Todo
- [x] Can add actions to every announcement
- [x] Provide a resource/action to send announcement
- [ ] Add banner-like implementations for global announcement

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
- [margarizaldi](https://github.com/margarizaldi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
