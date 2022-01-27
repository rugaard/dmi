<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Types\ClimateType;
use Rugaard\DMI\Units\Pressure\Hectopascal;
use Rugaard\DMI\Units\Pressure\Kilopascal;

/**
 * Class Pressure.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Pressure extends AbstractClimateData
{
    /**
     * Temperature constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = $this->type === ClimateType::PressureVapourMeanDeficit ? new Kilopascal() : new Hectopascal();
    }
}
