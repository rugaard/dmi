<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\DTO;

/**
 * Class BoundingBox.
 */
class BoundingBox extends DTO
{
    /**
     * Southwest coordinate.
     *
     * @var Coordinate
     */
    public Coordinate $southwest;

    /**
     * Northeast coordinate.
     *
     * @var Coordinate
     */
    public Coordinate $northeast;

    /**
     * Location constructor.
     *
     * @param array|Collection $data
     */
    public function __construct(array|Collection $data)
    {
        // Ignore parent constructor.
        parent::__construct(data: []);

        // Make sure data is a Collection.
        $data = Collection::wrap(value: $data);

        // Set southwest coordinate.
        $this->southwest = new Coordinate(data: $data->slice(offset: 0, length: 2));

        // Set northeast coordinate.
        $this->northeast = new Coordinate(data: $data->slice(offset: 2, length: 2)->values());
    }


}
