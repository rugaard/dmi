<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use Rugaard\DMI\Support\Attributes\Location as HasLocation;
use Rugaard\DMI\Support\Attributes\CreatedTimestamp as HasCreatedTimestamp;
use Rugaard\DMI\Enums\Meteorological\StationCountry;
use Rugaard\DMI\Support\FromGeoJson;

/**
 * Class Station.
 */
abstract class Station extends DTO
{
    use FromGeoJson, HasLocation, HasCreatedTimestamp;

    /**
     * Station UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * Station ID.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Stations name.
     *
     * @var string
     */
    public string $name;

    /**
     * Country where station is located.
     *
     * @var StationCountry
     */
    public StationCountry $country;

    /**
     * Set station country.
     *
     * @param string $countryCode
     * @return $this
     */
    protected function setCountry(string $countryCode): self
    {
        $this->country = StationCountry::from(value: $countryCode);
        return $this;
    }

}
