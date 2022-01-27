<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\AbstractObservation;

/**
 * Class WeatherCondition.
 *
 * @package Rugaard\DMI\DTO\Meteorological
 */
class WeatherCondition extends AbstractObservation
{
    /**
     * WeatherCondition constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        //$this->unit = null;
    }
}
