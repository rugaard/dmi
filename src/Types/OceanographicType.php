<?php

declare(strict_types=1);

namespace Rugaard\DMI\Types;

use Rugaard\DMI\DTO\Oceanographic\SeaLevel;
use Rugaard\DMI\DTO\Oceanographic\Temperature;

/**
 * Enum OceanographicType.
 *
 * @package Rugaard\DMI\Types
 * @return string
 *
 */
enum OceanographicType: string
{
    /**
     * Sea level registration.
     *
     * Recommended when looking at data from Kystdirektoratet / Coastal Authority.
     * Data fra the Coastal Authority is measured in DVR90.
     *
     * Update interval: 10 min.
     */
    case SeaLevel = 'sea_reg';

    /**
     * Sea level relative to DVR90 (Danish Vertical Reference 1990).
     *
     * Recommended when looking at data from DMIs stations after January 1st 1997.
     *
     * Update interval: 10 min.
     */
    case SeaLevelDVR = 'sealev_dvr';

    /**
     * Sea level relative to local zero for the station.
     *
     * Recommended when looking at data from DMIs stations before Januar 1st 1997.
     *
     * Update interval: 10 min.
     */
    case SeaLevelLocalZero = 'sealev_ln';

    /**
     * Water temperature.
     *
     * Water temperature is a support value, which is required for calculating the sea
     * level for a certain type of tide gauge.
     *
     * The water temperature is measured inside the harbor at a depth of a couple of meters
     * relatively to the undisturbed sea surface.
     *
     * The measurement is therefore not standardized and should be used with this reservation.
     *
     * Update interval: 10 min.
     */
    case TemperatureWater = 'tw';

    /**
     * Get description of oceanographic type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::SeaLevel => 'Sea level registration.' . "\n" . 'Recommended when looking at data from Kystdirektoratet / Coastal Authority. Data fra the Coastal Authority is measured in DVR90.',
            self::SeaLevelDVR => 'Sea level relative to DVR90 (Danish Vertical Reference 1990).' . "\n" . 'Recommended when looking at data from DMIs stations after January 1st 1997.',
            self::SeaLevelLocalZero => 'Sea level relative to local zero for the station.' . "\n" . 'Recommended when looking at data from DMIs stations before Januar 1st 1997.',
            self::TemperatureWater => 'Water temperature is a support value, which is required for calculating the sea level for a certain type of tide gauge.' . "\n" . 'The water temperature is measured inside the harbor at a depth of a couple of meters relatively to the undisturbed sea surface.' . "\n" . 'The measurement is therefore not standardized and should be used with this reservation.',
        };
    }

    /**
     * Get class namespace of matching oceanographic type.
     *
     * @return string
     */
    public function type(): string
    {
        return match ($this) {
            self::SeaLevel, self::SeaLevelDVR, self::SeaLevelLocalZero => SeaLevel::class,
            self::TemperatureWater => Temperature::class,
        };
    }
}
