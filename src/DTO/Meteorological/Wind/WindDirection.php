<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Wind;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Bearing;

/**
 * Class WindDirection.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Wind
 */
class WindDirection extends AbstractObservation
{
    /**
     * WindDirection constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Bearing();
    }
}
