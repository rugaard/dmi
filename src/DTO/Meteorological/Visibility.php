<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Length\Meter;

/**
 * Class Visibility.
 *
 * @package Rugaard\DMI\DTO\Meteorological
 */
class Visibility extends AbstractObservation
{
    /**
     * Visibility constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Meter();
    }
}
