<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use DateTime;
use DateTimeZone;
use Exception;

/**
 * Trait UpdatedTimestamp.
 */
trait UpdatedTimestamp
{
    /**
     * Timestamp of update in DMI system.
     *
     * @var DateTime|null
     */
    public ?DateTime $updatedAt = null;

    /**
     * Set timestamp of update.
     *
     * @param string|null $datetime
     * @return $this
     */
    protected function setUpdated(?string $datetime): self
    {
        try {
            $this->updatedAt = $datetime !== null ? (new DateTime($datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC')) : null;
        } catch (Exception) {
            //
        }
        return $this;
    }
}
