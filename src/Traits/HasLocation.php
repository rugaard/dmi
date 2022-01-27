<?php

declare(strict_types=1);

namespace Rugaard\DMI\Traits;

use Rugaard\DMI\Contracts\Location;
use Rugaard\DMI\Support\Coordinates;
use Rugaard\DMI\Support\Location\Point;

/**
 * Trait HasLocation.
 *
 * @package Rugaard\DMI\Traits
 */
trait HasLocation
{
    /**
     * Parse location data.
     *
     * @param array $data
     * @return \Rugaard\DMI\Contracts\Location|null
     */
    protected function parseLocation(array $data):? Location
    {
        return match ($data['type'] ?? null) {
            'Point' => new Point(new Coordinates($data['coordinates'][1], $data['coordinates'][0])),
            default => null
        };
    }
}
