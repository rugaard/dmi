<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Units;

use Rugaard\DMI\Old\Contracts\Unit;

/**
 * Class Bearing.
 *
 * @package Rugaard\DMI\Old\Units
 */
class Bearing implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Bearing';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = '°';

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
