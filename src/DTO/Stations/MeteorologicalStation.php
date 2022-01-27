<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Stations;

use Rugaard\DMI\Abstracts\AbstractStation;
use Rugaard\DMI\DTO\WorldMeteorologicalOrganization;
use Tightenco\Collect\Support\Collection;

/**
 * Class MeteorologicalStation.
 *
 * @package Rugaard\DMI\DTO\Stations
 */
class MeteorologicalStation extends AbstractStation
{
    /**
     * Stations height.
     *
     * @var int
     */
    public int $stationHeight;

    /**
     * Height of barometer on station.
     *
     * @var float
     */
    public float $barometerHeight;

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
