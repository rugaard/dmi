<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Rugaard\DMI\Abstracts\AbstractDTO;

/**
 * Class WorldMeteorologicalOrganization.
 *
 * @package Rugaard\DMI\DTO
 */
class WorldMeteorologicalOrganization extends AbstractDTO
{
    /**
     * WMO station ID.
     *
     * @var string|null
     */
    public ?string $stationId;

    /**
     * WMO region ID.
     *
     * @var string|null
     */
    public ?string $regionId;

    /**
     * WMO country code.
     *
     * @var string|null
     */
    public ?string $countryCode;
}
