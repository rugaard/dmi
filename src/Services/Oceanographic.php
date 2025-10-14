<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use GeoJson\Feature\Feature;
use GeoJson\Feature\FeatureCollection;
use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Abstracts\Station;
use Rugaard\DMI\Client;
use Rugaard\DMI\Collections\ObservationCollection;
use Rugaard\DMI\DTO\Oceanographic\Tidewater;
use Rugaard\DMI\DTO\Stations\Oceanographic as OceanographicStation;
use Rugaard\DMI\DTO\Stations\Tidewater as TidewaterStation;
use Rugaard\DMI\Enums\Oceanographic\Filters\ObservationFilter;
use Rugaard\DMI\Enums\Oceanographic\Filters\StationFilter;
use Rugaard\DMI\Enums\Oceanographic\Filters\TidewaterPredictionFilter;
use Rugaard\DMI\Enums\Oceanographic\Parameter;
use Rugaard\DMI\Enums\Oceanographic\Filters\TidewaterStationFilter;
use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use ValueError;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

/**
 * Class Oceanographic.
 */
class Oceanographic extends Client
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
        $response = $this->request(method: 'get', url: 'collections/observation/items', query: $filters);

        // Parse each observation and return it as a Collection.
        return ObservationCollection::make(items: $response)->map(callback: static function (Feature $item) {
            try {
                // Get oceanographic parameter from payload.
                $parameter = Parameter::from(value: $item->getProperties()['parameterId'] ?? null);
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
        // Retrieve observation by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'collections/observation/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        // Determine observation parameter type.
        $parameter = Parameter::from(value: $response->getProperties()['parameterId'] ?? null);

        return $parameter->dto()::fromGeoJson(feature: $response);
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
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'collections/station/items', query: $filters);

        // Parse each station and return it as a Collection.
        return Collection::make(items: $response)->map(callback: fn (Feature $item) => OceanographicStation::fromGeoJson(feature: $item));
    }

    /**
     * Get observation station by ID.
     *
     * @param string $id
     * @return Station|null
     * @throws ParsingFailedException
     */
    public function stationById(string $id): ?Station
    {
        // Retrieve observation station by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'collections/station/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return OceanographicStation::fromGeoJson(feature: $response);
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
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'collections/station/items', query: ['stationId' => $stationId]);

        return Collection::make(items: $response)->map(callback: fn (Feature $item) => OceanographicStation::fromGeoJson(feature: $item));
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
     * Get all tidewater predictions.
     *
     * @param array $filters
     * @return ObservationCollection
     * @throws ParsingFailedException
     */
    public function tidewaterPredictions(array $filters = []): ObservationCollection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => TidewaterPredictionFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve tidewater predictions from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'collections/tidewater/items', query: $filters);

        // Parse each tidewater prediction and return it as a Collection.
        return ObservationCollection::make(items: $response)->map(callback: fn (Feature $item) => Tidewater::fromGeoJson(feature: $item));
    }

    /**
     * Get tidewater prediction by ID.
     *
     * @param string $id
     * @return Observation|null
     * @throws ParsingFailedException
     */
    public function tidewaterPredictionById(string $id): ?Observation
    {
        // Retrieve tidewater prediction by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'collections/tidewater/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        // Determine observation parameter type.
        $parameter = Parameter::from(value: $response->getProperties()['parameterId'] ?? null);

        return $parameter->dto()::fromGeoJson(feature: $response);
    }

    /**
     * Get all tidewater stations.
     *
     * @param array $filters
     * @return Collection
     * @throws ParsingFailedException
     */
    public function tidewaterStations(array $filters = []): Collection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => TidewaterStationFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve all observation stations from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'collections/tidewaterstation/items', query: $filters);

        // Parse each station and return it as a Collection.
        return Collection::make(items: $response)->map(callback: fn (Feature $item) => TidewaterStation::fromGeoJson(feature: $item));
    }

    /**
     * Get tidewater station by ID.
     *
     * @param string $id
     * @return Station|null
     * @throws ParsingFailedException
     */
    public function tidewaterStationById(string $id): ?Station
    {
        // Retrieve tidewater station by ID from API.
        /** @var Feature|null $response */
        $response = $this->request(method: 'get', url: 'collections/tidewaterstation/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return TidewaterStation::fromGeoJson(feature: $response);
    }

    /**
     * Get tidewater station(s) by ID.
     *
     * @param string $stationId
     * @return Collection
     * @throws ParsingFailedException
     */
    public function tidewaterStationByStationId(string $stationId): Collection
    {
        // Retrieve observation station by ID from API.
        /** @var FeatureCollection|null $response */
        $response = $this->request(method: 'get', url: 'collections/tidewaterstation/items', query: ['stationId' => $stationId]);

        return Collection::make(items: $response)->map(callback: fn (Feature $item) => TidewaterStation::fromGeoJson(feature: $item));
    }

    /**
     * Get tidewater station(s) by name.
     *
     * @param string $stationName
     * @return Collection
     * @throws ParsingFailedException
     */
    public function tidewaterStationByName(string $stationName): Collection
    {
        return $this->tidewaterStations()->where(key: 'name', operator: '=', value: $stationName)->values();
    }

    /**
     * Get service name.
     *
     * @return Service
     */
    public function service(): Service
    {
        return Service::Oceanographic;
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
