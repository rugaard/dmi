<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Snow;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Meteorological as MeteorologicalObservation;
use Rugaard\DMI\Units\Length\Centimeter;

/**
 * Class Depth.
 */
class Depth extends MeteorologicalObservation
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
     * @var Centimeter
     */
    public Centimeter $unit;

    /**
     * Depth constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Centimeter;
    }

    /**
     * Set observation value.
     *
     * @param int|float $value
     * @return $this
     */
    public function setValue(int|float $value): self
    {
        $this->value = $value === -1 ? 0.5 : $value;
        return $this;
    }
}
