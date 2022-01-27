<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Humidity.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Humidity extends AbstractClimateData
{
    /**
     * Humidity constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Percentage();
    }
}
