<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Length\Millimeter;

/**
 * Class Precipitation.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Precipitation extends AbstractClimateData
{
    /**
     * Precipitation constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Millimeter();
    }
}
