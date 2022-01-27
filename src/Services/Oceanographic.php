<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use DateTime;
use DateTimeInterface;
use Rugaard\DMI\Abstracts\AbstractObservation;
use Rugaard\DMI\Client;
use Rugaard\DMI\Collections\ObservationsCollection;
use Rugaard\DMI\DTO\Stations\OceanographicStation;
use Rugaard\DMI\DTO\WorldMeteorologicalOrganization;
use Rugaard\DMI\Traits\HasLocation;
use Rugaard\DMI\Types\OceanographicType;
use Rugaard\DMI\Support\DateTimePeriod;
use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;

use function array_filter;
use function array_map;
use function array_merge;
use function in_array;

/**
 * Class Oceanographic.
 *
 * @package Rugaard\DMI\Services
 */
class Oceanographic extends Client
{
    use HasLocation;

    /**
     * Array of supported observation filters.
     *
     * @var string[]
     */
    protected array $observationFilters = [
        'bbox',
        'bbox-crs',
        'datetime',
        'limit',
        'offset',
        'parameterId',
        'period',
        'stationId',
        'sortorder'
    ];

    /**
     * Array of supported station filters.
     *
     * @var string[]
     */
    protected array $stationFilters = [
        'bbox',
        'bbox-crs',
        'datetime',
        'limit',
        'offset',
        'stationId',
        'status',
        'type'
    ];

    /**
     * Get all observations.
     *
     * @param array $filters
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getAllObservations(array $filters = []): ObservationsCollection
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->observationFilters, true), ARRAY_FILTER_USE_KEY);

        // Sort order.
        $filters = array_merge(['sortorder' => 'observed,DESC'], $filters);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'observation/items', $filters)
        );

        return $this->parseObservations($response);
    }

    /**
     * Get observation by ID.
     *
     * @param string $observationId
     * @param array $filters
     * @return \Rugaard\DMI\Abstracts\AbstractObservation
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getObservationById(string $observationId, array $filters = []): AbstractObservation
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->observationFilters, true), ARRAY_FILTER_USE_KEY);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'observation/items/' . $observationId, $filters)
        );

        return $this->parseObservation($response);
    }

    /**
     * Parse array of observations.
     *
     * @param array $data
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     */
    protected function parseObservations(array $data): ObservationsCollection
    {
        // Observations container.
        $observations = ObservationsCollection::make();

        // Parse all observations.
        foreach ($data['features'] as $observation) {
            $observations->push(
                $this->parseObservation($observation)
            );
        }

        return $observations;
    }

    /**
     * Parse observation.
     *
     * @param array $data
     * @return \Rugaard\DMI\Abstracts\AbstractObservation
     */
    protected function parseObservation(array $data): AbstractObservation
    {
        // Determine type of observation
        $observationType = OceanographicType::from($data['properties']['parameterId']);

        return new ($observationType->type())(
            id: $data['id'],
            type: $observationType,
            value: $data['properties']['value'],
            stationId: $data['properties']['stationId'],
            location: $data['geometry'] !== null ? $this->parseLocation($data['geometry']) : null,
            timestamp: DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['observed'])
        );
    }

    /**
     * Get all stations.
     *
     * @param array $filters
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getAllStations(array $filters = []): Collection
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->stationFilters, true), ARRAY_FILTER_USE_KEY);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'station/items', $filters)
        );

        return $this->parseStations($response);
    }

    /**
     * Get stations by station ID.
     *
     * @param string $stationId
     * @param array $filters
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getStationsByStationId(string $stationId, array $filters = []): Collection
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->stationFilters, true), ARRAY_FILTER_USE_KEY);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'station/items/', array_merge($filters, ['stationId' => $stationId]))
        );

        return $this->parseStations($response);
    }

    /**
     * Get station by UUID.
     *
     * @param string $stationUuid
     * @param array $filters
     * @return \Rugaard\DMI\DTO\Stations\OceanographicStation
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getStationById(string $stationUuid, array $filters = []): OceanographicStation
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->stationFilters, true), ARRAY_FILTER_USE_KEY);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'station/items/' . $stationUuid, $filters)
        );

        return $this->parseStation($response);
    }

    /**
     * Parse array of stations.
     *
     * @param array $data
     * @return \Tightenco\Collect\Support\Collection
     */
    protected function parseStations(array $data): Collection
    {
        // Stations container.
        $stations = Collection::make();

        // Parse all stations.
        foreach ($data['features'] as $station) {
            $stations->push(
                $this->parseStation($station)
            );
        }

        return $stations;
    }

    /**
     * Parse station.
     *
     * @param array $data
     * @return \Rugaard\DMI\DTO\Stations\OceanographicStation
     */
    protected function parseStation(array $data): OceanographicStation
    {
        // Parsed station data.
        $station = Arr::except($data['properties'], [
            'regionId', 'wmoStationId', 'wmoCountryCode',
            'operationFrom', 'operationTo', 'status', 'parameterId',
            'validFrom', 'validTo', 'created', 'updated'
        ]);

        // Stations UUID.
        $station['id'] = $data['id'];

        // Stations supported measurements
        $station['measurements'] = Collection::make(array_map(static fn(string $parameter) => OceanographicType::from($parameter), $data['properties']['parameterId']));

        // Location of station.
        $station['location'] = $data['geometry'] !== null ? $this->parseLocation($data['geometry']) : null;

        // Status of station.
        $station['isActive'] = $data['properties']['status'] === 'Active';

        // World Meteorological Organization.
        $station['wmo'] = (!empty($data['properties']['regionId']) || !empty($data['properties']['wmoCountryCode']) || !empty($data['properties']['wmoStationId']))
            ? new WorldMeteorologicalOrganization(stationId: $data['properties']['wmoStationId'], regionId: $data['properties']['regionId'], countryCode: $data['properties']['wmoCountryCode'])
            : null;

        // Period of where station is/was operational.
        $station['operational'] = new DateTimePeriod(fromDate: $data['properties']['operationFrom'], toDate: $data['properties']['operationTo'] ?? null);

        // Period of where data is valid.
        $station['valid'] = new DateTimePeriod(fromDate: $data['properties']['validFrom'], toDate: $data['properties']['validTo'] ?? null);

        // Created / Updated timestamp in DMI database.
        $station['created'] = !empty($data['properties']['created']) ? DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['created']) : null;
        $station['updated'] = !empty($data['properties']['updated']) ? DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['updated']) : null;

        return new OceanographicStation($station);
    }

    /**
     * Get service name.
     *
     * @return string
     */
    protected function getServiceName(): string
    {
        return 'oceanObs';
    }

    /**
     * Get version of API service.
     *
     * @return int|float
     */
    protected function getServiceVersion(): int|float
    {
        return 2;
    }
}
