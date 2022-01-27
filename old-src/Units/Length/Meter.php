<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Units\Length;

use Rugaard\OldDMI\Contracts\Unit;

/**
 * Class Meter.
 *
 * @package Rugaard\OldDMI\Units\Length
 */
class Meter implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Meter';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = 'm';

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
