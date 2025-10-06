<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Meteorological as MeteorologicalObservation;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Sunshine.
 */
class Sunshine extends MeteorologicalObservation
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
     * @var Minute
     */
    public Minute $unit;

    /**
     * Sunshine constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Minute;
    }
}
