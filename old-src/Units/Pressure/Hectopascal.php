<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Units\Pressure;

use Rugaard\OldDMI\Contracts\Unit;

/**
 * Class Hectopascal.
 *
 * @package Rugaard\OldDMI\Units\Pressure
 */
class Hectopascal implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Hectopascal';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = 'hPa';

    /**
     * Get unit name.
     *
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * Get unit abbreviation.
     *
     * @return string
     */
    public function getAbbreviation() : string
    {
        return $this->abbreviation;
    }

    /**
     * Get unit as a string.
     *
     * @return string
     */
    public function __toString() : string
    {
        return $this->getAbbreviation();
    }
}
