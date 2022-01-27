<?php
declare(strict_types=1);

namespace Rugaard\DMI\Support;

use Tightenco\Collect\Support\Collection;

/**
 * Class Location.
 *
 * @package Rugaard\DMI\Support
 */
class Location
{
    /**
     * Type of location.
     *
     * @var string
     */
    protected string $type;

    /**
     * Coordinate(s) of location.
     *
     * @var \Tightenco\Collect\Support\Collection|\Rugaard\DMI\Support\Coordinate
     */
    protected Collection|Coordinate $coordinates;

    /**
     * Location constructor.
     *
     * @param string $type
     * @param array $coordinates
     */
    public function __construct(string $type, array $coordinates)
    {
        $this->setType($type)
             ->setCoordinates($coordinates);
    }

    /**
     * Set type of location.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get type of location.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set coordinate(s) of location.
     *
     * @param array $coordinates
     * @return $this
     */
    public function setCoordinates(array $coordinates): self
    {
        if (!is_array($coordinates[0])) {
            $this->coordinates = new Coordinate($coordinates[1], $coordinates[0]);
            return $this;
        }

        $allCoordinates = Collection::make();
        foreach ($coordinates as $coordinate) {
            $allCoordinates->push(new Coordinate($coordinate[1], $coordinate[0]));
        }

        $this->coordinates = $allCoordinates;
        return $this;
    }

    /**
     * Get coordinate(s) of location.
     *
     * @return \Tightenco\Collect\Support\Collection|\Rugaard\DMI\Support\Coordinate
     */
    public function getCoordinates(): Collection|Coordinate
    {
        return $this->coordinates;
    }
}
