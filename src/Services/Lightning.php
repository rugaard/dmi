<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use DateTime;
use DateTimeInterface;
use Rugaard\DMI\Abstracts\AbstractDTO;
use Rugaard\DMI\Client;
use Rugaard\DMI\Collections\LightningCollection;
use Rugaard\DMI\DTO\Lightning\SensorData;
use Rugaard\DMI\DTO\Stations\LightningStation;
use Rugaard\DMI\Support\DateTimePeriod;
use Rugaard\DMI\Traits\HasLocation;
use Rugaard\DMI\Types\LightningType;
use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;

use function array_filter;
use function array_merge;
use function in_array;

/**
 * Class Lightning.
 *
 * @package Rugaard\DMI\Services
 */
class Lightning extends Client
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
        'period',
        'sortorder',
        'type'
    ];

    /**
     * Array of supported sensor data filters.
     *
     * @var string[]
     */
    protected array $sensorDataFilters = [
        'bbox',
        'bbox-crs',
        'offset',
        'limit',
        'period',
        'sortorder',
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
        'sortorder',
        'status'
    ];

    /**
     * Get all observations.
     *
     * @param array $filters
     * @return \Rugaard\DMI\Collections\LightningCollection
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getAllObservations(array $filters = []): LightningCollection
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
     * @return \Rugaard\DMI\Abstracts\AbstractDTO
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getObservationById(string $observationId, array $filters = []): AbstractDTO
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
     * @return \Rugaard\DMI\Collections\LightningCollection
     */
    protected function parseObservations(array $data): LightningCollection
    {
        // Observations container.
        $observations = LightningCollection::make();

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
     * @return \Rugaard\DMI\Abstracts\AbstractDTO
     */
    protected function parseObservation(array $data): AbstractDTO
    {
        // Determine type of observation
        $lightningType = LightningType::from((string) $data['properties']['type']);

        return new ($lightningType->type())(
            id: $data['id'],
            type: $lightningType,
            strokes: (int) $data['properties']['strokes'],
            value: $data['properties']['amp'],
            location: $data['geometry'] !== null ? $this->parseLocation($data['geometry']) : null,
            sensors: Collection::make(explode(',', $data['properties']['sensors'])),
            observed: DateTime::createFromFormat(DateTimeInterface::RFC3339_EXTENDED, $data['properties']['observed']),
            created: DateTime::createFromFormat(DateTimeInterface::RFC3339_EXTENDED, $data['properties']['created']),
        );
    }

    /**
     * Get all sensor data.
     *
     * @param array $filters
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getAllSensorData(array $filters = []): Collection
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->sensorDataFilters, true), ARRAY_FILTER_USE_KEY);

        // Sort order.
        $filters = array_merge(['sortorder' => 'observed,DESC'], $filters);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'sensordata/items', $filters)
        );

        return $this->parseSensorDataItems($response);
    }

    /**
     * Get sensor data by ID.
     *
     * @param string $sensorDataId
     * @param array $filters
     * @return \Rugaard\DMI\Abstracts\AbstractDTO
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getSensorDataById(string $sensorDataId, array $filters = []): AbstractDTO
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->sensorDataFilters, true), ARRAY_FILTER_USE_KEY);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'sensordata/items/' . $sensorDataId, $filters)
        );

        return $this->parseSensorData($response);
    }

    /**
     * Parse array of sensor data.
     *
     * @param array $data
     * @return \Rugaard\DMI\Collections\LightningCollection
     */
    protected function parseSensorDataItems(array $data): Collection
    {
        // Observations container.
        $observations = Collection::make();

        // Parse all observations.
        foreach ($data['features'] as $observation) {
            $observations->push(
                $this->parseSensorData($observation)
            );
        }

        return $observations;
    }

    /**
     * Parse sensor data.
     *
     * @param array $data
     * @return \Rugaard\DMI\Abstracts\AbstractDTO
     */
    protected function parseSensorData(array $data): AbstractDTO
    {
        return new SensorData(
            id: $data['id'],
            sensorId: $data['properties']['sensorId'],
            strokes: (int) $data['properties']['strokes'],
            value: $data['properties']['amp'],
            direction: (float) $data['properties']['direction'],
            location: $data['geometry'] !== null ? $this->parseLocation($data['geometry']) : null,
            observed: DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $data['properties']['observed']),
            created: DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $data['properties']['created']),
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
     * Get station by UUID.
     *
     * @param string $stationUuid
     * @param array $filters
     * @return \Rugaard\DMI\DTO\Stations\LightningStation
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getStationById(string $stationUuid, array $filters = []): LightningStation
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
     * @return \Rugaard\DMI\DTO\Stations\LightningStation
     */
    protected function parseStation(array $data): LightningStation
    {
        // Parsed station data.
        $station = Arr::except($data['properties'], [
            'status', 'lastHeartbeat', 'operationFrom', 'operationTo',
            'validFrom', 'validTo', 'created', 'updated'
        ]);

        // Stations UUID.
        $station['id'] = $data['id'];

        // Location of station.
        $station['location'] = $data['geometry'] !== null ? $this->parseLocation($data['geometry']) : null;

        // Status of station.
        $station['isActive'] = $data['properties']['status'] === 'Active';

        // Last heartbeat of station.
        $station['lastHeartbeat'] = !empty($data['properties']['lastHeartbeat']) ? DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['lastHeartbeat']) : null;

        // Period of where station is/was operational.
        $station['operational'] = new DateTimePeriod(fromDate: $data['properties']['operationFrom'], toDate: $data['properties']['operationTo'] ?? null);

        // Period of where data is valid.
        $station['valid'] = new DateTimePeriod(fromDate: $data['properties']['validFrom'], toDate: $data['properties']['validTo'] ?? null);

        // Created / Updated timestamp in DMI database.
        $station['created'] = !empty($data['properties']['created']) ? DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['created']) : null;
        $station['updated'] = !empty($data['properties']['updated']) ? DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['updated']) : null;

        return new LightningStation($station);
    }

    /**
     * Get service name.
     *
     * @return string
     */
    protected function getServiceName(): string
    {
        return 'lightningdata';
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
