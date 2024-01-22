<?php

namespace Rupadana\FilamentDashboardNotification\Commands;

use Illuminate\Console\Command;

class FilamentDashboardNotificationCommand extends Command
{
    public $signature = 'filament-dashboard-notification';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
