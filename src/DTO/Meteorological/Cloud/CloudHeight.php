<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Cloud;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Length\Meter;

/**
 * Class CloudHeight.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Cloud
 */
class CloudHeight extends AbstractObservation
{
    /**
     * CloudHeight constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Meter();
    }
}
