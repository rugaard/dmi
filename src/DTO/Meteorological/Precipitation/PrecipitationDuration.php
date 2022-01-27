<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Precipitation;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class PrecipitationDuration.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Precipitation
 */
class PrecipitationDuration extends AbstractObservation
{
    /**
     * PrecipitationDuration constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Minute();
    }
}
