<?php

declare(strict_types=1);

namespace Rugaard\DMI;

use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Services\Lightning;
use Rugaard\DMI\Services\Meteorological;
use Rugaard\DMI\Services\Oceanographic;

use function array_flip;
use function array_intersect_key;
use function array_map;

/**
 * Class DMI.
 */
final readonly class DMI
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
     * Interact with Meteorological service.
     *
     * @return Meteorological
     * @throws DMIException
     */
    public function meteorological(): Meteorological
    {
        return new Meteorological(apiKey: $this->apiKeys['meteorological'] ?? null);
    }

    /**
     * Interact with Oceanographic service.
     *
     * @return Oceanographic
     * @throws DMIException
     */
    public function oceanographic(): Oceanographic
    {
        return new Oceanographic(apiKey: $this->apiKeys['oceanographic'] ?? null);
    }

    /**
     * Interact with Lightning service.
     *
     * @return Lightning
     * @throws DMIException
     */
    public function lightning(): Lightning
    {
        return new Lightning(apiKey: $this->apiKeys['lightning'] ?? null);
    }

    /**
     * Get a list of supported DMI services.
     *
     * @return string[]
     */
    private function getSupportedServices(): array
    {
        return array_map(callback: fn (Service $service) => strtolower(string: $service->name), array: Service::cases());
    }
}
