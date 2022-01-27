<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Oceanographic;

use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Units\Length\Centimeter;

/**
 * Class SeaLevel.
 *
 * @package Rugaard\DMI\DTO\Oceanographic
 */
class SeaLevel extends AbstractObservation
{
    /**
     * Visibility constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Centimeter();
    }
}
