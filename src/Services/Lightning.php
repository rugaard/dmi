<?php
declare(strict_types=1);

namespace Rugaard\DMI\Services;

use DateTimeInterface;
use Rugaard\DMI\Client;
use Rugaard\DMI\Contracts\DTO;
use Rugaard\DMI\Contracts\Service;
use Rugaard\DMI\DTO\Observations\Lightning as LightningObservations;
use Rugaard\DMI\DTO\Station\Lightning as LightningStation;
use Tightenco\Collect\Support\Collection;

/**
 * Class Lightning.
 *
 * @package Rugaard\DMI\Services
 */
class Lightning extends Client implements Service
{
    /**
     * Get all observations (raw data).
     *
     * @param array $options
     * @return \Rugaard\DMI\DTO\Observations\Lightning
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function observations(array $options = []): LightningObservations
    {
        // Default options.
        $options = array_merge([
            'sortorder' => 'observed,DESC'
        ], $options);

        // Send request.
        $data = $this->request('observation', null, $options);

        // Parse observations.
        return new LightningObservations($data['features']);
    }

    /**
     * Get observation by ID.
     *
     * @param string $observationId
     * @return \Rugaard\DMI\Contracts\DTO
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function observation(string $observationId): DTO
    {
        // Send request.
        $data = $this->request('observation', $observationId);

        return (new LightningObservations([$data]))->get()->first();
    }

    /**
     * Get all individual sensor observations (raw data).
     *
     * @param array $options
     * @return \Rugaard\DMI\DTO\Observations\Lightning
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function sensorObservations(array $options = []): LightningObservations
    {
        // Default options.
        $options = array_merge([
            'sortorder' => 'observed,DESC'
        ], $options);

        // Send request.
        $data = $this->request('sensordata', null, $options);

        // Parse observations.
        return new LightningObservations($data['features']);
    }

    /**
     * Get sensor observation by ID.
     *
     * @param string $sensorObservationId
     * @return \Rugaard\DMI\Contracts\DTO
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function sensorObservation(string $sensorObservationId): DTO
    {
        // Send request.
        $data = $this->request('sensordata', $sensorObservationId);

        return (new LightningObservations([$data]))->get()->first();
    }

    /**
     * Get all stations.
     *
     * @param array $options
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function stations(array $options = []): Collection
    {
        // Default options.
        $options = array_merge([
            'status' => 'Active',
            'datetime' => date(DateTimeInterface::RFC3339),
        ],  $options);

        // Send request.
        $data = $this->request('station', null, $options);

        // Parsed stations container.
        $stations = Collection::make();

        // Parse stations.
        foreach ($data['features'] as $station) {
            $stations->push(new LightningStation($station));
        }

        return $stations;
    }

    /**
     * Get station by UUID.
     *
     * @param string $stationUuid
     * @param array $options
     * @return \Rugaard\DMI\DTO\Stations\Lightning
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function station(string $stationUuid, array $options = []): LightningStation
    {
        return new LightningStation(
            // Send request.
            $this->request('station', $stationUuid, $options)
        );
    }

    /**
     * Get all observations from a specific station.
     *
     * @param string $stationUuid
     * @param array $options
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function stationObservations(string $stationUuid, array $options = []): Collection
    {
        // Get station by ID.
        $station = $this->station($stationUuid);

        // Default options.
        $options = array_merge([
            'sortorder' => 'observed,DESC'
        ], $options, [
            'stationId' => $station->getId()
        ]);

        // Send request.
        $data = $this->request('observation', null, $options);

        // Parse observations.
        $observations = new LightningObservations($data['features']);

        return Collection::make([
            'station' => $station,
            'observations' => $observations
        ]);
    }

    /**
     * Get all stations sorted by distance to coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $options
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function nearestStations(float $latitude, float $longitude, array $options = []): Collection
    {
        return $this->stations($options)->map(function ($station) use ($latitude, $longitude) {
            return $station->calculateDistance($latitude, $longitude);
        })->sortBy(function ($station) {
            return $station->getDistance()->meters();
        })->values();
    }

    /**
     * Get nearest station by coordinates.
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $options
     * @return \Rugaard\DMI\DTO\Stations\Lightning
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function nearestStation(float $latitude, float $longitude, array $options = []): LightningStation
    {
        return $this->nearestStations($latitude, $longitude, $options)->first();
    }

    /**
     * Get observations by nearest station.
     *
     * @param float $latitude
     * @param float $longitude
     * @param array $options
     * @return \Tightenco\Collect\Support\Collection
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function nearestStationObservations(float $latitude, float $longitude, array $options = []): Collection
    {
        // Get nearest station by coordinates.
        $station = $this->nearestStation($latitude, $longitude);

        // Default options.
        $options = array_merge([
            'sortorder' => 'observed,DESC'
        ], $options, [
            'stationId' => $station->getId()
        ]);

        // Send request.
        $data = $this->request('observation', null, $options);

        // Parse observations.
        $observations = new LightningObservations($data['features']);

        return Collection::make([
            'station' => $station,
            'observations' => $observations
        ]);
    }

    /**
     * Get service name.
     *
     * @return string
     */
    public function getServiceName(): string
    {
        return 'lightningdata';
    }

    /**
     * Get service version.
     *
     * @return string
     */
    public function getServiceVersion(): string
    {
        return 'v2';
    }
}
