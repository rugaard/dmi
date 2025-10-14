<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\DTO;

/**
 * Class Coordinate.
 */
class Coordinate extends DTO
{
    /**
     * Latitude coordinate.
     *
     * @var float
     */
    public float $latitude;

    /**
     * Longitude coordinate.
     *
     * @var float
     */
    public float $longitude;

    /**
     * Location constructor.
     *
     * @param array|Collection $data
     */
    public function __construct(array|Collection $data)
    {
        // Make sure data is a Collection.
        $data = Collection::wrap(value: $data);

        parent::__construct(data: [
            'latitude' => (float) $data->get(key: 0),
            'longitude' => (float) $data->get(key: 1),
        ]);
    }
}
