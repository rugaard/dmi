<?php

declare(strict_types=1);

namespace Rugaard\DMI;

use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\DMIException;
use Rugaard\DMI\Services\Meteorological;

use function array_flip;
use function array_intersect_key;
use function array_map;

/**
 * Class DMI.
 */
final class DMI
{
    /**
     * Service API keys.
     *
     * @var array
     */
    private readonly array $apiKeys;

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
     * @throws DMIException
     */
    public function meteorological(): Meteorological
    {
        return new Meteorological(apiKey: $this->apiKeys['metObs'] ?? null);
    }

    /**
     * Get a list of supported DMI services.
     *
     * @return string[]
     */
    private function getSupportedServices(): array
    {
        return array_map(callback: fn (Service $service) => $service->value, array: Service::cases());
    }
}
