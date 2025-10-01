<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Units\Energy\WattPerSquareMeter;

/**
 * Class Radiation.
 */
class Radiation extends Observation
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
     * @var WattPerSquareMeter
     */
    public WattPerSquareMeter $unit;

    /**
     * Radiation constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new WattPerSquareMeter;
    }
}
