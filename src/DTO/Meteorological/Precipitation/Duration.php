<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Precipitation;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Meteorological as MeteorologicalObservation;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Duration.
 */
class Duration extends MeteorologicalObservation
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
     * Duration constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Minute;
    }

    /**
     * Set observation value.
     *
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = $value === -0.1 ? 0.1 : $value;
        return $this;
    }
}
