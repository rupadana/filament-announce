<?php

namespace Rupadana\FilamentDashboardNotification\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rupadana\FilamentDashboardNotification\FilamentDashboardNotification
 */
class FilamentDashboardNotification extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rupadana\FilamentDashboardNotification\FilamentDashboardNotification::class;
    }
}
