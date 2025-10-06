<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * Trait ObservedTimestamp.
 */
trait ObservedTimestamp
{
    /**
     * Timestamp of observation.
     *
     * @var DateTime
     */
    public DateTime $observedAt;

    /**
     * Set timestamp of observation.
     *
     * @param string $datetime
     * @return $this
     */
    protected function setObserved(string $datetime): self
    {
        try {
            $this->observedAt = (new DateTime($datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC'));
        } catch (Exception) {
            //
        }
        return $this;
    }
}
