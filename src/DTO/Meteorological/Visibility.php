<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Units\Length\Meter;

/**
 * Class Visibility.
 */
class Visibility extends Observation
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
     * @var Meter
     */
    public Meter $unit;

    /**
     * Visibility constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Meter;
    }
}
