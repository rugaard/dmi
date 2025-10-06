<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Oceanographic;

use Rugaard\DMI\DTO\Oceanographic\SeaLevel;
use Rugaard\DMI\DTO\Oceanographic\Temperature;

/**
 * Enum Parameter.
 *
 * @return string
 */
enum Parameter: string
{
    /**
     * Sea level relative to DVR90 (Danish Vertical Reference 1990).
     *
     * Update interval: 10 min.
     *
     * Note: Since medio 2001 sea level has been measured every 10 minutes.
     * Before that sea level was measured every 15 minutes, 30 minutes and
     * for the oldest data every hour on the hour.
     *
     * Recommended use: When looking at data from DMIs stations after January 1st 1997.
     */
    case SeaLevelDVR = 'sealev_dvr';

    /**
     * Sea level relative to local zero for the station.
     *
     * Update interval: 10 min.
     *
     * Note: Since medio 2001 sea level has been measured every 10 minutes.
     * Before that sea level was measured every 15 minutes, 30 minutes and
     * for the oldest data every hour on the hour.
     *
     * Recommended use: When looking at data from DMIs stations before Januar 1st 1997
     */
    case SeaLevelLocal = 'sealev_ln';

    /**
     * Sea level registration
     *
     * Update interval: 10 min.
     *
     * Note: Since medio 2001 sea level has been measured every 10 minutes.
     * Before that sea level was measured every 15 minutes, 30 minutes and
     * for the oldest data every hour on the hour.
     *
     * Recommended use: When looking at data from Kystdirektoratet / Coastal Authority.
     * Data fra the Coastal Authority is measured in DVR90.
     */
    case SeaLevelRegistration = 'sea_reg';

    /**
     * Water temperature
     *
     * Update interval: 10 min.
     *
     * Recommended use: Water temperature is a support value, which is required for calculating
     * the sea level for a certain type of tide gauge. The water temperature is measured inside
     * the harbor at a depth of a couple of meters relatively to the undisturbed sea surface.
     * The measurement is therefore not standardized and should be used with this reservation.
     */
    case WaterTemperature = 'tw';

    /**
     * Get description of oceanographic type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::SeaLevelDVR => 'Sea level relative to DVR90 (Danish Vertical Reference 1990)',
            self::SeaLevelLocal => 'Sea level relative to local zero for the station',
            self::SeaLevelRegistration => 'Sea level registration',
            self::WaterTemperature => 'Temperature of water',
        };
    }

    /**
     * Get DTO class namespace.
     *
     * @return class-string
     */
    public function dto(): string
    {
        return match ($this) {
            self::SeaLevelDVR, self::SeaLevelLocal, self::SeaLevelRegistration => SeaLevel::class,
            self::WaterTemperature => Temperature::class,
        };
    }
}
