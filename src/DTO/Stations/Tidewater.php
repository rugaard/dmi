<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Stations;

use Rugaard\DMI\Abstracts\Station;
use Rugaard\DMI\Support\Attributes\CreatedTimestamp as HasCreatedTimestamp;

/**
 * Class Tidewater.
 */
class Tidewater extends Station
{
    use HasCreatedTimestamp;

    /**
     * Mean low water springs (MLWS).
     *
     * @var float
     */
    public float $meanLowWaterSpring;

    /**
     * Lowest astronomical tide (LAT).
     *
     * @var float
     */
    public float $lowestAstronomicalTide;

    /**
     * Set lowest astronomical tide.
     *
     * @param float $value
     * @return $this
     */
    public function setLowAstronomicalTide(float $value): self
    {
        $this->lowestAstronomicalTide = $value;
        return $this;
    }
}
