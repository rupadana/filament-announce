<?php

namespace Rupadana\FilamentAnnounce\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Rupadana\FilamentAnnounce\FilamentAnnounce
 */
class FilamentAnnounce extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Rupadana\FilamentAnnounce\FilamentAnnounce::class;
    }
}
