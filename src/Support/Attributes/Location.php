<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use GeoJson\Geometry\Geometry as GeoJsonGeometry;
use Rugaard\DMI\DTO\Location as LocationDTO;

/**
 * Trait Location.
 */
trait Location
{
    /**
     * Location of object.
     *
     * @var LocationDTO|null
     */
    public ?LocationDTO $location;

    /**
     * Set location of object.
     *
     * @param GeoJsonGeometry|null $geometry
     * @return $this
     */
    protected function setLocation(?GeoJsonGeometry $geometry): self
    {
        $this->location = $geometry !== null ? new LocationDTO(data: [
            'type' => $geometry->getType(),
            'coordinates' => $geometry->getCoordinates(),
        ]) : null;
        return $this;
    }
}
