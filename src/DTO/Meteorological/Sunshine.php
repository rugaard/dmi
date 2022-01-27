<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Sunshine.
 *
 * @package Rugaard\DMI\DTO\Meteorological
 */
class Sunshine extends AbstractObservation
{
    /**
     * Sunshine constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Minute();
    }
}
