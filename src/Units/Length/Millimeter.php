<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Contracts\Unit;

/**
 * Class Millimeter.
 *
 * @package Rugaard\DMI\Units\Length
 */
class Millimeter implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Millimeter';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = 'mm';

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
