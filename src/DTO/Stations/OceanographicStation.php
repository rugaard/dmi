<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Stations;

use Rugaard\DMI\Abstracts\AbstractStation;
use Rugaard\DMI\DTO\WorldMeteorologicalOrganization;
use Tightenco\Collect\Support\Collection;

/**
 * Class OceanographicStation.
 *
 * @package Rugaard\DMI\DTO\Stations
 */
class OceanographicStation extends AbstractStation
{
    /**
     * Instrument parameter.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    public Collection $instrumentParameter;

    /**
     * Lists of supported measurements.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    public Collection $measurements;

    /**
     * WMO information.
     *
     * @var \Rugaard\DMI\DTO\WorldMeteorologicalOrganization
     */
    public WorldMeteorologicalOrganization $wmo;
}
