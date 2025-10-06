<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Oceanographic;

/**
 * Enum PredictionType.
 *
 * @return string
 */
enum PredictionType: string
{
    /**
     * Tidewater predictions where level is at a minimum.
     */
    case Minimum = 'minimum';

    /**
     * Tidewater predictions where level is at a maximum.
     */
    case Maximum = 'maximum';

    /**
     * Tidewater predictions for every 10 minutes.
     */
    case TenMinutes = '10minutes';

    /**
     * Get description of prediction type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::Minimum => 'Tidewater predictions where level is at a minimum',
            self::Maximum => 'Tidewater predictions where level is at a maximum',
            self::TenMinutes => 'Tidewater predictions for every 10 minutes',
        };
    }

//    /**
//     * Get DTO class namespace.
//     *
//     * @return class-string
//     */
//    public function dto(): string
//    {
//        return match ($this) {
//            self::SeaLevelDVR, self::SeaLevelLocal, self::SeaLevelRegistration => SeaLevel::class,
//            self::WaterTemperature => Temperature::class,
//        };
//    }
}
