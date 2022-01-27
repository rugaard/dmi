<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Snow;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Length\Centimeter;

/**
 * Class Snow.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Snow
 */
class Snow extends AbstractObservation
{
    /**
     * Snow constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Centimeter();
    }
}
