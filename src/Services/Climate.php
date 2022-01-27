<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use DateTime;
use DateTimeInterface;
use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\Stations\MeteorologicalStation;
use Rugaard\DMI\DTO\WorldMeteorologicalOrganization;
use Rugaard\DMI\Traits\HasLocation;
use Rugaard\DMI\Types\ClimateType;
use Rugaard\DMI\Types\MeteorologicalType;
use Rugaard\DMI\Support\DateTimePeriod;
use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;

use function array_filter;
use function array_map;
use function array_merge;
use function in_array;

/**
 * Class Climate.
 *
 * @package Rugaard\DMI\Services
 */
class Climate extends Client
{
    use HasLocation;

    /**
     * Array of supported station value filters.
     *
     * @var string[]
     */
    protected array $stationValueFilters = [
        'bbox',
        'bbox-crs',
        'datetime',
        'limit',
        'offset',
        'parameterId',
        'sortorder',
        'stationId',
        'status',
        'timeResolution'
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
        'status'
    ];

    /**
     * Get all station values.
     *
     * @param array $filters
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getAllStationValues(array $filters = []): Collection
    {
        // Validate filters.
        $filters = array_filter($filters, fn(string $filter) => in_array($filter, $this->stationValueFilters, true), ARRAY_FILTER_USE_KEY);

        // Sort order.
        $filters = array_merge(['sortorder' => 'from,DESC'], $filters);

        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'stationValue/items', $filters)
        );

        return $this->parseStationValues($response);
    }

    /**
     * Get station value by UUID.
     *
     * @param string $stationValueUUID
     * @return \Rugaard\DMI\Abstracts\AbstractClimateData
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getStationValueById(string $stationValueUUID): AbstractClimateData
    {
        // Build and send request.
        $response = $this->request(
            $this->buildRequest('get', 'stationValue/items/' . $stationValueUUID)
        );

        return $this->parseStationValue($response);
    }

    /**
     * Parse array of station values.
     *
     * @param array $data
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     */
    protected function parseStationValues(array $data): Collection
    {
        // Station values container.
        $stationValues = Collection::make();

        // Parse all station values.
        foreach ($data['features'] as $stationValue) {
            $stationValues->push(
                $this->parseStationValue($stationValue)
            );
        }

        return $stationValues;
    }

    /**
     * Parse station value.
     *
     * @param array $data
     * @return \Rugaard\DMI\Abstracts\AbstractClimateData
     */
    protected function parseStationValue(array $data): AbstractClimateData
    {
        // Determine climate data type.
        $climateDataType = ClimateType::from($data['properties']['parameterId']);

        // Station value.
        $stationValue = Arr::except($data['properties'], [
            'calculatedAt', 'created', 'from', 'to', 'parameterId', 'qcStatus', 'validity'
        ]);

        // Station value UUID.
        $stationValue['id'] = $data['id'];

        // Station value climate data type.
        $stationValue['type'] = $climateDataType;

        // Station value time period.
        $timePeriodFrom = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $data['properties']['from']) ?: DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['from']);
        $timePeriodTo = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $data['properties']['to']) ?: DateTime::createFromFormat(DateTimeInterface::RFC3339, $data['properties']['to']);
        $stationValue['timePeriod'] = new DateTimePeriod(fromDate:$timePeriodFrom, toDate: $timePeriodTo);

        // Station value based on number of values.
        if (isset($data['properties']['noValuesInCalculation'])) {
            $stationValue['basedOnNumberOfValues'] = $data['properties']['noValuesInCalculation'];
        }

        // Location of station value.
        $stationValue['location'] = $data['geometry'] !== null ? $this->parseLocation($data['geometry']) : null;

        // Status of station value.
        $stationValue['isQualityControlled'] = $data['properties']['qcStatus'] === 'manual';

        // Station value is considered valid.
        $stationValue['isConsideredValid'] = $data['properties']['validity'];

        // Timestamps of station value.
        $stationValue['calculatedAt'] = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $data['properties']['calculatedAt']);
        $stationValue['createdAt'] = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $data['properties']['created']);

        return new ($climateDataType->type())($stationValue);
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
     * @return \Rugaard\DMI\DTO\Stations\MeteorologicalStation
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function getStationById(string $stationUuid, array $filters = []): MeteorologicalStation
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
     * @return \Rugaard\DMI\DTO\Stations\MeteorologicalStation
     */
    protected function parseStation(array $data): MeteorologicalStation
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
        $station['measurements'] = Collection::make(array_map(static fn(string $parameter) => MeteorologicalType::from($parameter), $data['properties']['parameterId']));

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

        return new MeteorologicalStation($station);
    }

    /**
     * Get service name.
     *
     * @return string
     */
    protected function getServiceName(): string
    {
        return 'climateData';
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
