<?php
declare(strict_types=1);

namespace Rugaard\DMI\Contracts;

/**
 * Interface Unit
 *
 * @package Rugaard\DMI\Contracts
 */
interface Unit
{
    /**
     * Get name of unit.
     *
     * @return string
     */
    public function getName() : string;

    /**
     * Get abbreviation of unit.
     *
     * @return string
     */
    public function getAbbreviation() : string;

    /**
     * Get unit as a string.
     *
     * @return string
     */
    public function __toString() : string;
}