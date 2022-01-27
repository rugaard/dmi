<?php

declare(strict_types=1);

namespace Rugaard\DMI;

use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Services\Climate;
use Rugaard\DMI\Services\Lightning;
use Rugaard\DMI\Services\Meteorological;

use Rugaard\DMI\Services\Oceanographic;

use function array_flip;
use function array_intersect_key;

/**
 * Class DMI.
 *
 * @package Rugaard\DMI
 */
final class DMI
{
    /**
     * Service API keys.
     *
     * @var array
     */
    private array $apiKeys;

    /**
     * DMI constructor.
     *
     * @param array $apiKeys
     */
    public function __construct(array $apiKeys = [])
    {
        $this->apiKeys = array_intersect_key($apiKeys, array_flip($this->getSupportedServices()));
    }

    /**
     * Use the meteorological service.
     *
     * @param string|null $apiKey
     * @return \Rugaard\DMI\Services\Meteorological
     * @throws \Exception
     */
    public function useMeteorological(string $apiKey = null): Meteorological
    {
        return new Meteorological($apiKey ?? $this->getApiKey('meteorological'));
    }

    /**
     * Use the oceanographic service.
     *
     * @param string|null $apiKey
     * @return \Rugaard\DMI\Services\Oceanographic
     * @throws \Exception
     */
    public function useOceanographic(string $apiKey = null): Oceanographic
    {
        return new Oceanographic($apiKey ?? $this->getApiKey('oceanographic'));
    }

    /**
     * Use the climate service.
     *
     * @param string|null $apiKey
     * @return \Rugaard\DMI\Services\Climate
     * @throws \Exception
     */
    public function useClimate(string $apiKey = null): Climate
    {
        return new Climate($apiKey ?? $this->getApiKey('climate'));
    }

    /**
     * Use the lightning service.
     *
     * @param string|null $apiKey
     * @return \Rugaard\DMI\Services\Lightning
     * @throws \Exception
     */
    public function useLightning(string $apiKey = null): Lightning
    {
        return new Lightning($apiKey ?? $this->getApiKey('lightning'));
    }

    /**
     * Get service API key by service name.
     *
     * @param string $serviceName
     * @return string
     * @throws \Exception
     */
    private function getApiKey(string $serviceName): string
    {
        return $this->apiKeys[$serviceName] ?? throw new DMIException('No API key for service [' . $serviceName . '] provided.');
    }

    /**
     * Get a list of supported DMI services.
     *
     * @return string[]
     */
    private function getSupportedServices(): array
    {
        return [
            'climate',
            'lightning',
            'meteorological',
            'oceanographic',
            'radar'
        ];
    }
}
