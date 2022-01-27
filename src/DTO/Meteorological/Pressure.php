<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Pressure\Hectopascal;

/**
 * Class Pressure.
 *
 * @package Rugaard\DMI\DTO\Meteorological
 */
class Pressure extends AbstractObservation
{
    /**
     * Pressure constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Hectopascal();
    }
}
