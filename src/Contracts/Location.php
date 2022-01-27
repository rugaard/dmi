<?php

declare(strict_types=1);

namespace Rugaard\DMI\Contracts;

use Rugaard\DMI\Support\Coordinates;

/**
 * Interface Location.
 *
 * @package Rugaard\DMI\Contracts
 */
interface Location
{
    /**
     * Get type of location.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Get location coordinates.
     *
     * @return \Rugaard\DMI\Support\Coordinates|array
     */
    public function getCoordinates(): Coordinates|array;
}
