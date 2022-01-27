<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Units\Time;

use Rugaard\OldDMI\Contracts\Unit;

/**
 * Class Hour.
 *
 * @package Rugaard\OldDMI\Units\Time
 */
class Hour implements Unit
{
    /**
     * Name of unit.
     *
     * @var string
     */
    protected $name = 'Hour';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected $abbreviation = 'h';

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
