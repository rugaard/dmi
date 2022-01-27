<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Units\Temperature;

use Rugaard\OldDMI\Contracts\Unit;

/**
 * Class Celsius.
 *
 * @package Rugaard\OldDMI\Units\Temperatures
 */
class Celsius implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Celsius';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = '°C';

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
