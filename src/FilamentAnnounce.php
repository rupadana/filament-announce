<?php

namespace Rupadana\FilamentAnnounce;

class FilamentAnnounce
{
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
}
