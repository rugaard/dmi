<?php
declare(strict_types=1);

namespace Rugaard\DMI\Support;

/**
 * Class Distance.
 *
 * @package Rugaard\DMI\Support
 */
class Distance
{
    /**
     * Distance in meters.
     *
     * @var float
     */
    protected float $value;

    /**
     * Distance constructor.
     *
     * @param int|float $distanceInMeters
     */
    public function __construct(int|float $distanceInMeters)
    {
        $this->value = (float) $distanceInMeters;
    }

    /**
     * Get distance in meters.
     *
     * @return float
     */
    public function meters(): float
    {
        return $this->value;
    }

    /**
     * Get distance in feet.
     *
     * @return float
     */
    public function feet(): float
    {
        return $this->value * 3.2808399;
    }

    /**
     * Get distance in kilometers.
     *
     * @return float
     */
    public function kilometers(): float
    {
        return $this->value / 1000;
    }

    /**
     * Get distance in miles.
     *
     * @return float
     */
    public function miles(): float
    {
        return $this->value / 1609.344;
    }

    /**
     * Get distance in nautical miles.
     *
     * @return float
     */
    public function nauticalMiles(): float
    {
        return $this->value / 1852;
    }
}
