<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Oceanographic;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Oceanographic as OceanographicObservation;
use Rugaard\DMI\Units\Length\Centimeter;

/**
 * Class SeaLevel.
 */
class SeaLevel extends OceanographicObservation
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
     * SeaLevel constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Centimeter;
    }
}
