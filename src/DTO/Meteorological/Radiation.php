<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Energy\WattPerSquareMeter;

/**
 * Class Radiation.
 *
 * @package Rugaard\DMI\DTO\Meteorological
 */
class Radiation extends AbstractObservation
{
    /**
     * Radiation constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new WattPerSquareMeter();
    }
}
