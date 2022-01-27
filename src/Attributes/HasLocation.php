<?php
declare(strict_types=1);

namespace Rugaard\DMI\Attributes;

use Rugaard\DMI\Support\Location;

/**
 * Trait HasLocation.
 *
 * @package Rugaard\DMI\Attributes
 */
trait HasLocation
{
    /**
     * Location attribute.
     *
     * @var \Rugaard\DMI\Support\Location|null
     */
    protected ?Location $location;

    /**
     * Set location attribute.
     *
     * @param string $type
     * @param array $coordinates
     * @return $this
     */
    public function setLocation(string $type, array $coordinates): self
    {
        if (empty($coordinates[1]) || empty($coordinates[0])) {
            return $this;
        }

        $this->location = new Location($type, $coordinates);
        return $this;
    }

    /**
     * Get location attribute.
     *
     * @return \Rugaard\DMI\Support\Location
     */
    public function getLocation():? Location
    {
        return $this->location;
    }
}
