<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support;

/**
 * Class Coordinates.
 *
 * @package Rugaard\DMI\Support\Location
 */
class Coordinates
{
    /**
     * Latitude coordinate.
     *
     * @var float
     */
    protected float $latitude;

    /**
     * Longitude coordinate.
     *
     * @var float
     */
    protected float $longitude;

    /**
     * Coordinates constructor.
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
     * Get latitude coordinate.
     *
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * Get longitude coordinate.
     *
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * Get coordinates as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];
    }

    /**
     * Get coordinates as string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->latitude . ',' . $this->longitude;
    }
}
