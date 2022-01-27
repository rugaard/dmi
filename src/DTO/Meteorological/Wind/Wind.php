<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Wind;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Speed\MetersPerSecond;

/**
 * Class Wind.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Wind
 */
class Wind extends AbstractObservation
{
    /**
     * Wind constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new MetersPerSecond();
    }
}
