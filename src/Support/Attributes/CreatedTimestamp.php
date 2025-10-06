<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * Trait CreatedTimestamp.
 */
trait CreatedTimestamp
{
    /**
     * Timestamp of creation in DMI system.
     *
     * @var DateTime
     */
    public DateTime $createdAt;

    /**
     * Set timestamp of creation.
     *
     * @param string $datetime
     * @return $this
     */
    protected function setCreated(string $datetime): self
    {
        try {
            $this->createdAt = (new DateTime($datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC'));
        } catch (Exception) {
            //
        }
        return $this;
    }
}
