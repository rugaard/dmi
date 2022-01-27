<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Humidity.
 *
 * @package Rugaard\DMI\DTO\Meteorological
 */
class Humidity extends AbstractObservation
{
    /**
     * Humidity constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Percentage();
    }
}
