<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Contracts\Unit;

/**
 * Class MillijoulePerSquareMeter.
 *
 * @package Rugaard\DMI\Units\Energy
 */
class MillijoulePerSquareMeter implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected string $name = 'Millijoule per square meter';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'mJ/m²';

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
