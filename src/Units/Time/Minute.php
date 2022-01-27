<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Contracts\Unit;

/**
 * Class Minute.
 *
 * @package Rugaard\DMI\Units\Time
 */
class Minute implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected string $name = 'Minute';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'min.';

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
