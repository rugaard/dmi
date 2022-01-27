<?php
declare(strict_types=1);

namespace Rugaard\DMI\Attributes;

use DateTime;

/**
 * Trait HasObservedTimestamp.
 *
 * @package Rugaard\DMI\Attributes
 */
trait HasObservedTimestamp
{
    /**
     * Timestamp of observation.
     *
     * @var \DateTime|null
     */
    protected ?DateTime $observedAt;

    /**
     * Set observation timestamp.
     *
     * @param string $timestamp
     * @return $this
     */
    public function setObservedAt(string $timestamp): self
    {
        $this->observedAt = date_create($timestamp);
        return $this;
    }

    /**
     * Get observation timestamp.
     *
     * @return \DateTime
     */
    public function getObservedAt(): DateTime
    {
        return $this->observedAt;
    }
}
