<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Wind;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Meteorological as MeteorologicalObservation;
use Rugaard\DMI\Units\Bearing;

/**
 * Class Direction.
 */
class Direction extends MeteorologicalObservation
{
    /**
     * Value of observation.
     *
     * @var int
     */
    public int $value;

    /**
     * Unit of value.
     *
     * @var Bearing
     */
    public Bearing $unit;

    /**
     * Direction constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Bearing;
    }

    /**
     * Set observation value.
     *
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = (int) $value;
        return $this;
    }
}
