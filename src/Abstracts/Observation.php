<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use GeoJson\Geometry\Geometry as GeoJsonGeometry;
use Rugaard\DMI\DTO\Location;
use Rugaard\DMI\Enums\Meteorological\Parameter as MeteorologicalType;
use Rugaard\DMI\Support\FromGeoJson;

/**
 * Class Observation.
 */
abstract class Observation extends DTO
{
    use FromGeoJson;

    /**
     * Observation UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * ID of observation station.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Observation parameter.
     *
     * @var MeteorologicalType
     */
    public MeteorologicalType $parameter;

    /**
     * Description of observation.
     *
     * @var string
     */
    public string $description;

    /**
     * Time of observation.
     *
     * @var DateTime
     */
    public DateTime $timestamp;

    /**
     * Location of observation.
     *
     * @var Location
     */
    public Location $location;

    /**
     * Set parameter and description from parameter ID.
     *
     * @param string $parameterId
     * @return $this
     */
    protected function setParameterId(string $parameterId): self
    {
        // Get parameter from parameter ID.
        $parameter = $this->parameter = MeteorologicalType::from(value: $parameterId);

        // Set observation description from parameter.
        $this->description = $parameter->description();

        return $this;
    }

    /**
     * Set location of observation.
     *
     * @param GeoJsonGeometry $geometry
     * @return $this
     */
    protected function setLocation(GeoJsonGeometry $geometry): self
    {
        $this->location = new Location(data: [
            'type' => $geometry->getType(),
            'coordinates' => $geometry->getCoordinates(),
        ]);
        return $this;
    }

    /**
     * Set timestamp of observation.
     *
     * @param string $datetime
     * @return $this
     */
    protected function setObserved(string $datetime): self
    {
        $this->timestamp = DateTime::createFromFormat(format: DateTimeInterface::RFC3339, datetime: $datetime)->setTimezone(timezone: new DateTimeZone(timezone: 'UTC'));
        return $this;
    }
}
