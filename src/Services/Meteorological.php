<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Abstracts\Station;
use Rugaard\DMI\Client;
use Rugaard\DMI\Collections\ObservationCollection;
use Rugaard\DMI\DTO\Stations\Meteorological as MeteorologicalStation;
use Rugaard\DMI\Enums\Meteorological\Filters\ObservationFilter;
use Rugaard\DMI\Enums\Meteorological\Filters\StationFilter;
use Rugaard\DMI\Enums\Meteorological\Parameter;
use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use ValueError;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

/**
 * Class Meteorological.
 */
class Meteorological extends Client
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
        $response = $this->request(method: 'get', url: 'collections/observation/items', query: $filters);

        // Parse each observation and return it as a Collection.
        return ObservationCollection::make(items: $response['features'] ?? [])->map(callback: static function (array $item) {
            try {
                // Get meteorological parameter from payload.
                $parameter = Parameter::from(value: $item['properties']['parameterId'] ?? null);
                return $parameter->dto()::fromGeoJson(feature: $item);
            } catch (ValueError) {
                // Should we for some reason hit an unsupported parameter,
                // then we'll jump ship and return null, so we can remove it later.
                return null;
            }
        })->filter();
    }

    /**
     * Get observation by ID.
     *
     * @param string $id
     * @return Observation|null
     * @throws ParsingFailedException
     */
    public function observationById(string $id): ?Observation
    {
        // Retrieve observation station by ID from API.
        $response = $this->request(method: 'get', url: 'collections/observation/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        // Determine observation parameter type.
        $parameter = Parameter::from(value: $response['properties']['parameterId'] ?? null);

        return $parameter->dto()::fromGeoJson(payload: $response);
    }

    /**
     * Get all observation stations.
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
        $response = $this->request(method: 'get', url: 'collections/station/items', query: $filters);

        // Parse each station and return it as a Collection.
        return Collection::make(items: $response['features'] ?? [])->map(callback: fn (array $item) => MeteorologicalStation::fromGeoJson(payload: $item));
    }

    /**
     * Get observation station by UUID.
     *
     * @param string $id
     * @return Station|null
     * @throws ParsingFailedException
     */
    public function stationById(string $id): ?Station
    {
        // Retrieve observation station by ID from API.
        $response = $this->request(method: 'get', url: 'collections/station/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return MeteorologicalStation::fromGeoJson(payload: $response);
    }

    /**
     * Get observation station(s) by ID.
     *
     * @param string $stationId
     * @return Collection
     * @throws ParsingFailedException
     */
    public function stationByStationId(string $stationId): Collection
    {
        // Retrieve observation station by ID from API.
        $response = $this->request(method: 'get', url: 'collections/station/items', query: ['stationId' => $stationId]);

        return Collection::make(items: $response['features'] ?? [])->map(callback: fn (array $item) => MeteorologicalStation::fromGeoJson(payload: $item));
    }

    /**
     * Get observation station(s) by name.
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
        return Service::Meteorological;
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
