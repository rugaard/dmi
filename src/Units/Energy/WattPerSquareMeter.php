<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Contracts\Unit;

/**
 * Class WattPerSquareMeter.
 *
 * @package Rugaard\DMI\Units\Energy
 */
class WattPerSquareMeter implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected string $name = 'Watts per square meter';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'W/m²';

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
