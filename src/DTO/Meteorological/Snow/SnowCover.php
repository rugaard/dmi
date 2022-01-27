<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Snow;

use Rugaard\DMI\Abstracts\AbstractObservation;

/**
 * Class SnowCover.
 *
 * @package Rugaard\DMI\DTO\Meteorological\Snow
 */
class SnowCover extends AbstractObservation
{
    /**
     * Snow constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        //$this->unit = null;
    }
}
