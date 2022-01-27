<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Cloud;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Cloud.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Cloud
 */
class Cloud extends AbstractObservation
{
    /**
     * Cloud constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Percentage();
    }
}
