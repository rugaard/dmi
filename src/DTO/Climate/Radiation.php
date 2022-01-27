<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Energy\MegajoulePerSquareMeter;
use Rugaard\DMI\Units\Energy\WattPerSquareMeter;

/**
 * Class Radiation.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Radiation extends AbstractClimateData
{
    /**
     * Radiation constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = $this->timeResolution === 'hour' ? new WattPerSquareMeter() : new MegajoulePerSquareMeter();
    }
}
