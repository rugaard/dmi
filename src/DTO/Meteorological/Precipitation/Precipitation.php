<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Precipitation;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Length\Millimeter;

/**
 * Class Precipitation.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Precipitation
 */
class Precipitation extends AbstractObservation
{
    /**
     * Precipitation constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Millimeter();
    }
}
