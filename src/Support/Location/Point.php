<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Location;

use Rugaard\DMI\Contracts\Location;
use Rugaard\DMI\Support\Coordinates;

/**
 * Class Point.
 *
 * @package Rugaard\DMI\Support\Location
 */
class Point implements Location
{
    /**
     * Coordinates of point.
     *
     * @var \Rugaard\DMI\Support\Coordinates
     */
    protected Coordinates $coordinates;

    /**
     * Point constructor.
     *
     * @param \Rugaard\DMI\Support\Coordinates $coordinates
     */
    public function __construct(Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
    }

    /**
     * Get point coordinates.
     *
     * @return \Rugaard\DMI\Support\Coordinates
     */
    public function getCoordinates(): Coordinates
    {
        return $this->coordinates;
    }

    /**
     * Return 'point' as location type.
     *
     * @return string
     */
    public function getType(): string
    {
        return 'point';
    }

    /**
     * Get point location as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->getType(),
            'coordinates' => $this->coordinates->toArray()
        ];
    }
}
