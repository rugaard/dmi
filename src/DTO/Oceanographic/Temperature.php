<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Oceanographic;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Temperature\Celsius;

/**
 * Class Temperature.
 *
 * @package Rugaard\DMI\DTO\Oceanographic
 */
class Temperature extends AbstractObservation
{
    /**
     * Temperature constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Celsius();
    }
}
