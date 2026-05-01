<?php

declare(strict_types=1);

namespace Rugaard\DMI;

use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Services\Climate;
use Rugaard\DMI\Services\Lightning;
use Rugaard\DMI\Services\Meteorological;
use Rugaard\DMI\Services\Oceanographic;
use Rugaard\DMI\Services\Radar;

use function array_map;

/**
 * Class DMI.
 */
final readonly class DMI
{
    /**
     * Create instance of Meteorological service.
     *
     * @return Meteorological
     */
    public static function meteorological(): Meteorological
    {
        return new Meteorological;
    }

    /**
     * Create instance of Oceanographic service.
     *
     * @return Oceanographic
     */
    public static function oceanographic(): Oceanographic
    {
        return new Oceanographic;
    }

    /**
     * Create instance of Climate service.
     *
     * @return Climate
     */
    public static function climate(): Climate
    {
        return new Climate;
    }

    /**
     * Create instance of Lightning service.
     *
     * @return Lightning
     */
    public static function lightning(): Lightning
    {
        return new Lightning;
    }

    /**
     * Create instance of Radar service.
     *
     * @return Radar
     */
    public static function radar(): Radar
    {
        return new Radar;
    }

    /**
     * Get a list of supported DMI services.
     *
     * @return string[]
     */
    public static function supportedServices(): array
    {
        return array_map(callback: fn (Service $service) => strtolower(string: $service->name), array: Service::cases());
    }
}
