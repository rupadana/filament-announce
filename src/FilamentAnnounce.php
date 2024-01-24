<?php

namespace Rupadana\FilamentAnnounce;

use Closure;

class FilamentAnnounce
{
    protected string | array | null $color = null;

    protected ?string $pollingInterval = null;

    /**
     * Get the value of pollingInterval
     */
    public function getPollingInterval()
    {
        return $this->pollingInterval;
    }

    /**
     * Set the value of pollingInterval
     *
     * @return self
     */
    public function pollingInterval(string $pollingInterval)
    {
        $this->pollingInterval = $pollingInterval;

        return $this;
    }

    /**
     * @param  string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | Closure | null  $color
     */
    public function color(string | array | Closure | null $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string | array{50: string, 100: string, 200: string, 300: string, 400: string, 500: string, 600: string, 700: string, 800: string, 900: string, 950: string} | null
     */
    public function getColor(): string | array | null
    {
        return $this->color;
    }
}
