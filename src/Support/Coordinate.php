<?php
declare(strict_types=1);

namespace Rugaard\DMI\Support;

/**
 * Class Coordinate.
 *
 * @package Rugaard\DMI\Support
 */
class Coordinate
{
    /**
     * Latitude position.
     *
     * @var float
     */
    protected float $latitude;

    /**
     * Longitude position.
     *
     * @var float
     */
    protected float $longitude;

    /**
     * Location constructor.
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    /**
     * Latitude position.
     *
     * @return float
     */
    public function latitude(): float
    {
        return $this->latitude;
    }

    /**
     * Longitude position.
     *
     * @return float
     */
    public function longitude(): float
    {
        return $this->longitude;
    }

    /**
     * Get coordinate as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    /**
     * __toString.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }
}
