<?php
declare(strict_types=1);

namespace Rugaard\DMI\Services;

use Rugaard\DMI\Client;
use Rugaard\DMI\Contracts\Service;
use Rugaard\DMI\DTO\Observations\Climate as ClimateObservations;

/**
 * Class Climate.
 *
 * @package Rugaard\DMI\Services
 */
class Climate extends Client implements Service
{
    /**
     * Get all station values (raw data).
     *
     * @param array $options
     * @return \Rugaard\DMI\DTO\Observations\Climate
     * @throws \Rugaard\DMI\Exceptions\DMIException
     * @throws \Rugaard\DMI\Exceptions\ParsingFailedException
     */
    public function observations(array $options = []): ClimateObservations
    {
        // Default options.
        $options = array_merge([
            #'sortorder' => 'observed,DESC'
        ], $options);

        // Send request.
        $data = $this->request('stationValue', null, $options);

        // Parse observations.
        return new ClimateObservations($data['features']);
    }

    /**
     * Get service name.
     *
     * @return string
     */
    public function getServiceName(): string
    {
        return 'climateData';
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
