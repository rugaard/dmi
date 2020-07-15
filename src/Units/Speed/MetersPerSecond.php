<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Speed;

use Rugaard\DMI\Contracts\Unit;

/**
 * Class MetresPerSecond.
 *
 * @package Rugaard\DMI\Units\Speed
 */
class MetersPerSecond implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Meters per second';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = 'm/s';

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
