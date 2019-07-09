<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Units\Temperature;

use Rugaard\DMI\Contracts\Unit;

/**
 * Class Celsius.
 *
 * @package Rugaard\DMI\DTO\Units
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