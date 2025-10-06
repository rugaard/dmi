<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use GeoJson\Feature\Feature;
use GeoJson\Feature\FeatureCollection;
use Illuminate\Support\Collection;
use Rugaard\DMI\Client;
use Rugaard\DMI\Collections\ObservationCollection;
use Rugaard\DMI\DTO\Lightning\Lightning as LightningDTO;
use Rugaard\DMI\DTO\Lightning\Sensor;
use Rugaard\DMI\DTO\Stations\Lightning as LightningStation;
use Rugaard\DMI\Enums\Lightning\Filters\StationFilter;
use Rugaard\DMI\Enums\Oceanographic\Filters\ObservationFilter;
use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use ValueError;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

/**
 * Class Oceanographic.
 */
class Lightning extends Client
{
    /**
     * Get all observations.
     *
     * @param array $filters
     * @return ObservationCollection
     * @throws ParsingFailedException
     */
    public function observations(array $filters = []): ObservationCollection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => ObservationFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve observations from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'observation/items', query: $filters);

        // Parse each observation and return it as a Collection.
        return ObservationCollection::make(items: $response)->map(callback: fn (Feature $item) => LightningDTO::fromGeoJson(feature: $item));
    }

    /**
     * Get observation by ID.
     *
     * @param string $id
     * @return LightningDTO|null
     * @throws ParsingFailedException
     */
    public function observationById(string $id): ?LightningDTO
    {
        // Retrieve observation by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'observation/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return LightningDTO::fromGeoJson(feature: $response);
    }

    /**
     * Get all sensor data.
     *
     * @param array $filters
     * @return ObservationCollection
     * @throws ParsingFailedException
     */
    public function sensorData(array $filters = []): ObservationCollection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => ObservationFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve observations from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'sensordata/items', query: $filters);

        // Parse each observation and return it as a Collection.
        return ObservationCollection::make(items: $response)->map(callback: fn (Feature $item) => Sensor::fromGeoJson(feature: $item));
    }

    /**
     * Get sensor data by ID.
     *
     * @param string $id
     * @return Sensor|null
     * @throws ParsingFailedException
     */
    public function sensorDataById(string $id): ?Sensor
    {
        // Retrieve sensor data by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'sensordata/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return Sensor::fromGeoJson(feature: $response);
    }

    /**
     * Get all lightning stations.
     *
     * @param array $filters
     * @return Collection
     * @throws ParsingFailedException
     */
    public function stations(array $filters = []): Collection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => StationFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve all observation stations from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'station/items', query: $filters);

        // Parse each station and return it as a Collection.
        return Collection::make(items: $response)->map(callback: fn (Feature $item) => LightningStation::fromGeoJson(feature: $item));
    }

    /**
     * Get lightning station by UUID.
     *
     * @param string $id
     * @return LightningStation|null
     * @throws ParsingFailedException
     */
    public function stationById(string $id): ?LightningStation
    {
        // Retrieve lightning station by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'station/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return LightningStation::fromGeoJson(feature: $response);
    }

    /**
     * Get lightning station(s) by ID.
     *
     * @param string $stationId
     * @return Collection
     * @throws ParsingFailedException
     */
    public function stationByStationId(string $stationId): Collection
    {
        // Retrieve lightning station by ID from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'station/items', query: ['stationId' => $stationId]);

        return Collection::make(items: $response)->map(callback: fn (Feature $item) => LightningStation::fromGeoJson(feature: $item));
    }

    /**
     * Get lightning station(s) by name.
     *
     * @param string $stationName
     * @return Collection
     * @throws ParsingFailedException
     */
    public function stationByName(string $stationName): Collection
    {
        return $this->stations()->where(key: 'name', operator: '=', value: $stationName)->values();
    }

    /**
     * Get service name.
     *
     * @return Service
     */
    public function service(): Service
    {
        return Service::Lightning;
    }

    /**
     * Get service version.
     *
     * @return string
     */
    public function serviceVersion(): string
    {
        return '2';
    }
}
