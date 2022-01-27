<?php
declare(strict_types=1);

namespace Rugaard\DMI\Attributes;

/**
 * Trait HasStation.
 *
 * @package Rugaard\DMI\Attributes
 */
trait HasStationId
{
    /**
     * Station attribute.
     *
     * @var string
     */
    protected string $stationId;

    /**
     * Set station ID attribute.
     *
     * @param string $stationId
     * @return $this
     */
    public function setStationId(string $stationId): self
    {
        $this->stationId = $stationId;
        return $this;
    }

    /**
     * Get station ID attribute.
     *
     * @return string
     */
    public function getStationId(): string
    {
        return $this->stationId;
    }
}
