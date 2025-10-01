<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Wind;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Units\Speed\MetersPerSecond;

/**
 * Class Speed.
 */
class Speed extends Observation
{
    /**
     * Value of observation.
     *
     * @var float
     */
    public float $value;

    /**
     * Unit of value.
     *
     * @var MetersPerSecond
     */
    public MetersPerSecond $unit;

    /**
     * Direction constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new MetersPerSecond;
    }
}
