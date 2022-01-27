<?php

declare(strict_types=1);

namespace Rugaard\DMI\Types;

use Rugaard\DMI\DTO\Climate\Cloud;
use Rugaard\DMI\DTO\Climate\DroughtIndex;
use Rugaard\DMI\DTO\Climate\EvaporationPotential;
use Rugaard\DMI\DTO\Climate\Humidity;
use Rugaard\DMI\DTO\Climate\LeafMoisture;
use Rugaard\DMI\DTO\Climate\Precipitation;
use Rugaard\DMI\DTO\Climate\Pressure;
use Rugaard\DMI\DTO\Climate\Radiation;
use Rugaard\DMI\DTO\Climate\Snow\Snow;
use Rugaard\DMI\DTO\Climate\Snow\SnowCover;
use Rugaard\DMI\DTO\Climate\Statistical;
use Rugaard\DMI\DTO\Climate\Sunshine;
use Rugaard\DMI\DTO\Climate\Temperature;
use Rugaard\DMI\DTO\Climate\Wind\Wind;
use Rugaard\DMI\DTO\Climate\Wind\WindDirection;

/**
 * Enum ClimateType.
 *
 * @package Rugaard\DMI\Types
 * @return string
 */
enum ClimateType: string
{
    /**
     * Mean temperature.
     */
    case TemperatureMean = 'mean_temp';

    /**
     * Mean of daily max temperature.
     */
    case TemperatureMeanMaximumDaily = 'mean_daily_max_temp';

    /**
     * Maximum temperature with associated date.
     */
    case TemperatureMaximumDate = 'max_temp_w_date';

    /**
     * Maximum temperature within the last 12 hours.
     */
    case TemperatureMaximumLast12Hours = 'max_temp_12h';

    /**
     * Mean of daily minimum temperature.
     */
    case TemperatureMeanMinimumDaily = 'mean_daily_min_temp';

    /**
     * Minimum temperature.
     */
    case TemperatureMinimum = 'min_temp';

    /**
     * Minimum temperature within the last 12 hours.
     */
    case TemperatureMinimumLast12Hours = 'min_temperature_12h';

    /**
     * Air temperature measured at grass height (5-20 cm. over terrain).
     *
     * This type is not quality controlled by DMIs climatologists.
     * As a result, data can be erroneous.
     */
    case TemperatureGround = 'temp_grass';

    /**
     * Temperature measured at a depth of 10 cm.
     *
     * This type is not quality controlled by DMIs climatologists.
     * As a result, data can be erroneous.
     */
    case TemperatureSoilLow = 'temp_soil_10';

    /**
     * Temperature measured at a depth of 30 cm.
     *
     * This type is not quality controlled by DMIs climatologists.
     * As a result, data can be erroneous.
     */
    case TemperatureSoilDeep = 'temp_soil_30';

    /**
     * Number of cold days (minimum temperature < -10°C).
     */
    case NumberOfColdDays = 'no_cold_days';

    /**
     * Number of ice days (maximum temperature < 0°C).
     */
    case NumberOfIceDays = 'no_ice_days';

    /**
     * Number of days with frost (minimum temperature < 0°C).
     */
    case NumberOfFrostDays = 'no_frost_days';

    /**
     * Number of tropical nights (minimum temperature > 20°C).
     */
    case NumberOfTropicalDays = 'no_tropical_nights';

    /**
     * Number of summer days (maximum temperature > 25°C).
     */
    case NumberOfSummerDays = 'no_summer_days';

    /**
     * Accumulated heating degree days (17°C - mean_temp) in Denmark
     * (in danish known as "graddage").
     */
    case NumberOfHeatingDaysDenmark = 'acc_heating_degree_days_17';

    /**
     * Accumulated heating degree days (19°C - mean_temp) in Greenland
     * (in danish known as "graddage").
     */
    case NumberOfHeatingDaysGreenland = 'acc_heating_degree_days_19';

    /**
     * Minimum relative humidity.
     */
    case HumidityRelativeMinimum = 'min_relative_hum';

    /**
     * Mean relative humidity.
     */
    case HumidityRelativeMean = 'mean_relative_hum';

    /**
     * Maximum relative humidity.
     */
    case HumidityRelativeMaximum = 'max_relative_hum';

    /**
     * Mean vapour pressure.
     */
    case PressureVapourMean = 'mean_vapour_pressure';

    /**
     * Mean vapour pressure deficit.
     * (in danish known as "mætningsdeficit").
     *
     * This type is not quality controlled by DMIs climatologists.
     * As a result, data can be erroneous.
     */
    case PressureVapourMeanDeficit = 'vapour_pressure_deficit_mean';

    /**
     * Minimum pressure.
     */
    case PressureMinimum = 'min_pressure';

    /**
     * Mean pressure.
     */
    case PressureMean = 'mean_pressure';

    /**
     * Maximum pressure.
     */
    case PressureMaximum = 'max_pressure';

    /**
     * Mean wind speed.
     */
    case WindSpeedMean = 'mean_wind_speed';

    /**
     * Maximum wind speed (3 seconds average).
     */
    case WindSpeedMaximumSecondsAverage = 'max_wind_speed_3sec';

    /**
     * Maximum wind speed (10 minutes average).
     */
    case WindSpeedMaximumMinutesAverage = 'max_wind_speed_10min';

    /**
     * Mean wind direction.
     */
    case WindDirectionMean = 'mean_wind_dir';

    /**
     * Mean wind direction (10 minutes average) at minute 0.
     */
    case WindDirectionMeanMinutely = 'mean_wind_dir_min0';

    /**
     * Number of windy days (mean wind speed >= 10.8 m/s).
     */
    case NumberOfWindyDays = 'no_windy_days';

    /**
     * Number of stormy days (mean wind speed >= 20.8 m/s).
     */
    case NumberOfStormyDays = 'no_stormy_days';

    /**
     * Number of days with storm (mean wind speed >= 24.5 m/s).
     */
    case NumberOfStormDays = 'no_days_w_storm';

    /**
     * Number of days with hurricane (mean wind speed >= 28.5 m/s).
     */
    case NumberOfHurricaneDays = 'no_days_w_hurricane';

    /**
     * Accumulated precipitation.
     */
    case PrecipitationTotal = 'acc_precip';

    /**
     * Corrected accumulated precipitation.
     */
    case PrecipitationTotalCorrected = 'corrected_acc_precip';

    /**
     * Accumulated precipitation during the last 12 hours.
     */
    case PrecipitationTotalLast12Hours = 'acc_precip_past12h';

    /**
     * Accumulated precipitation during the last 24 hours.
     */
    case PrecipitationTotalLast24Hours = 'acc_precip_past24h';

    /**
     * Maximum 24-hour precipitation accumulated with associated date.
     */
    case PrecipitationTotalMaximumDate = 'max_precip_24h';

    /**
     * Maximum 30 minutes intensity in 24 hours with associated date.
     */
    case PrecipitationMaximumIntensity30MinutesWithDate = 'max_precip_30m';

    /**
     * Number of days with accumulated precipitation >= 0.1 mm.
     */
    case NumberOfDaysWithPrecipitation = 'no_days_acc_precip_01';

    /**
     * Number of days with accumulated precipitation >= 1.0 mm.
     */
    case NumberOfDaysWithPrecipitationUnder10 = 'no_days_acc_precip_1';

    /**
     * Number of days with accumulated precipitation >= 10.0 mm.
     */
    case NumberOfDaysWithPrecipitationOver10 = 'no_days_acc_precip_10';

    /**
     * Snow depth.
     */
    case SnowDepth = 'snow_depth';

    /**
     * Maximum snow depth with date and location.
     */
    case SnowDepthMaximumWithDate = 'max_snow_depth';

    /**
     * Snow cover.
     */
    case SnowCover = 'snow_cover';

    /**
     * Number of days with snow cover (> 50% covered).
     */
    case NumberOfDaysWithSnowCover = 'no_days_snow_cover';

    /**
     * The fraction of the sky covered by cloud of any type or height above the ground.
     */
    case CloudCoverMean = 'mean_cloud_cover';

    /**
     * Number of clear days (mean cloud cover < 20%).
     */
    case NumberOfClearDays = 'no_clear_days';

    /**
     * Number of cloudy days (mean cloud cover > 80%).
     */
    case NumberOfCloudyDays = 'no_cloudy_days';

    /**
     * Minutes/hours of bright sunshine.
     *
     * Hourly time resolution is returned in "minutes",
     * all other time resolutions is returned in "hours".
     */
    case Sunshine = 'bright_sunshine';

    /**
     * Mean radiation (spectral range: 305-2800 nm.).
     *
     * Hourly time resolution is returned as "W/m^2",
     * all other time resolutions are returned as "MJ/m^2".
     */
    case Radiation = 'mean_radiation';

    /**
     * Drought index.
     */
    case DroughtIndex = 'drought_index';

    /**
     * Potential evaporation (Makkink).
     */
    case EvaporationPotentialMakkink = 'pot_evaporation_makkink';

    /**
     * Potential evaporation (Penman).
     */
    case EvaporationPotentialPenman = 'pot_evaporation_penman';

    /**
     * Leave moisture
     * (in danish known as "bladfugt").
     *
     * This type is not quality controlled by DMIs climatologists.
     * As a result, data can be erroneous.
     */
    case LeafMoisture = 'leaf_moisture';

    /**
     * Get description of climate type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::TemperatureMean => 'Mean temperature',
            self::TemperatureMeanMaximumDaily => 'Mean of daily max temperature',
            self::TemperatureMaximumDate => 'Maximum temperature with associated date',
            self::TemperatureMaximumLast12Hours => 'Maximum temperature within the last 12 hours',
            self::TemperatureMeanMinimumDaily => 'Mean of daily minimum temperature',
            self::TemperatureMinimum => 'Minimum temperature',
            self::TemperatureMinimumLast12Hours => 'Minimum temperature within the last 12 hours',
            self::TemperatureGround => 'Air temperature measured at grass height (5-20 cm. over terrain)' . "\n\n" . 'Note: This type is not quality controlled by DMIs climatologists. As a result, data can be erroneous',
            self::TemperatureSoilLow => 'Temperature measured at a depth of 10 cm.' . "\n\n" . 'Note: This type is not quality controlled by DMIs climatologists. As a result, data can be erroneous',
            self::TemperatureSoilDeep => 'Temperature measured at a depth of 30 cm.' . "\n\n" . 'Note: This type is not quality controlled by DMIs climatologists. As a result, data can be erroneous',
            self::NumberOfColdDays => 'Number of cold days (minimum temperature < -10°C)',
            self::NumberOfIceDays => 'Number of ice days (maximum temperature < 0°C)',
            self::NumberOfFrostDays => 'Number of days with frost (minimum temperature < 0°C)',
            self::NumberOfTropicalDays => 'Number of tropical nights (minimum temperature > 20°C)',
            self::NumberOfSummerDays => 'Number of summer days (maximum temperature > 25°C)',
            self::NumberOfHeatingDaysDenmark => 'Accumulated heating degree days (17°C - mean_temp) in Denmark (in danish known as "graddage")',
            self::NumberOfHeatingDaysGreenland => 'Accumulated heating degree days (19°C - mean_temp) in Greenland (in danish known as "graddage")',
            self::HumidityRelativeMinimum => 'Minimum relative humidity',
            self::HumidityRelativeMean => 'Mean relative humidity',
            self::HumidityRelativeMaximum => 'Maximum relative humidity',
            self::PressureVapourMean => 'Mean vapour pressure',
            self::PressureVapourMeanDeficit => 'Mean vapour pressure deficit (in danish known as "mætningsdeficit")' . "\n\n" . 'Note: This type is not quality controlled by DMIs climatologists. As a result, data can be erroneous',
            self::PressureMinimum => 'Minimum pressure',
            self::PressureMean => 'Mean pressure',
            self::PressureMaximum => 'Maximum pressure',
            self::WindSpeedMean => 'Mean wind speed',
            self::WindSpeedMaximumSecondsAverage => 'Maximum wind speed (3 seconds average)',
            self::WindSpeedMaximumMinutesAverage => 'Maximum wind speed (10 minutes average)',
            self::WindDirectionMean => 'Mean wind direction',
            self::WindDirectionMeanMinutely => 'Mean wind direction (10 minutes average) at minute 0',
            self::NumberOfWindyDays => 'Number of windy days (mean wind speed >= 10.8 m/s)',
            self::NumberOfStormyDays => 'Number of stormy days (mean wind speed >= 20.8 m/s)',
            self::NumberOfStormDays => 'Number of days with storm (mean wind speed >= 24.5 m/s)',
            self::NumberOfHurricaneDays => 'Number of days with hurricane (mean wind speed >= 28.5 m/s)',
            self::PrecipitationTotal => 'Accumulated precipitation',
            self::PrecipitationTotalCorrected => 'Corrected accumulated precipitation',
            self::PrecipitationTotalLast12Hours => 'Accumulated precipitation during the last 12 hours',
            self::PrecipitationTotalLast24Hours => 'Accumulated precipitation during the last 24 hours',
            self::PrecipitationTotalMaximumDate => 'Maximum 24-hour precipitation accumulated with associated date',
            self::PrecipitationMaximumIntensity30MinutesWithDate => 'Maximum 30 minutes intensity in 24 hours with associated date',
            self::NumberOfDaysWithPrecipitation => 'Number of days with accumulated precipitation >= 0.1 mm.',
            self::NumberOfDaysWithPrecipitationUnder10 => 'Number of days with accumulated precipitation >= 1.0 mm.',
            self::NumberOfDaysWithPrecipitationOver10 => 'Number of days with accumulated precipitation >= 10.0 mm.',
            self::SnowDepth => 'Snow depth',
            self::SnowDepthMaximumWithDate => 'Maximum snow depth with date and location',
            self::SnowCover => 'Snow cover',
            self::NumberOfDaysWithSnowCover => 'Number of days with snow cover (> 50% covered)',
            self::CloudCoverMean => 'The fraction of the sky covered by cloud of any type or height above the ground',
            self::NumberOfClearDays => 'Number of clear days (mean cloud cover < 20%)',
            self::NumberOfCloudyDays => 'Number of cloudy days (mean cloud cover > 80%)',
            self::Sunshine => 'Minutes/hours of bright sunshine.' . "\n\n" . 'Hourly time resolution is returned in "minutes", all other time resolutions is returned in "hours"',
            self::Radiation => 'Mean radiation (spectral range: 305-2800 nm.)' . "\n\n" . 'Hourly time resolution is returned as "W/m^2", all other time resolutions are returned as "MJ/m^2"',
            self::DroughtIndex => 'Drought index',
            self::EvaporationPotentialMakkink => 'Potential evaporation (Makkink)',
            self::EvaporationPotentialPenman => 'Potential evaporation (Penman)',
            self::LeafMoisture => 'Leave moisture (in danish known as "bladfugt")' . "\n\n" . 'Note: This type is not quality controlled by DMIs climatologists. As a result, data can be erroneous',
        };
    }

    /**
     * Get class namespace of matching climate type.
     *
     * @return string
     */
    public function type(): string
    {
        return match ($this) {
            self::TemperatureMean, self::TemperatureMeanMaximumDaily, self::TemperatureMaximumDate, self::TemperatureMaximumLast12Hours,
            self::TemperatureMeanMinimumDaily, self::TemperatureMinimum, self::TemperatureMinimumLast12Hours, self::TemperatureGround,
            self::TemperatureSoilLow, self::TemperatureSoilDeep => Temperature::class,
            self::HumidityRelativeMinimum, self::HumidityRelativeMean, self::HumidityRelativeMaximum => Humidity::class,
            self::PressureMinimum, self::PressureMean, self::PressureMaximum,
            self::PressureVapourMean, self::PressureVapourMeanDeficit => Pressure::class,
            self::WindSpeedMean, self::WindSpeedMaximumSecondsAverage, self::WindSpeedMaximumMinutesAverage => Wind::class,
            self::WindDirectionMean, self::WindDirectionMeanMinutely => WindDirection::class,
            self::PrecipitationTotal, self::PrecipitationTotalCorrected, self::PrecipitationTotalMaximumDate,
            self::PrecipitationTotalLast12Hours, self::PrecipitationTotalLast24Hours,
            self::PrecipitationMaximumIntensity30MinutesWithDate => Precipitation::class,
            self::SnowDepth, self::SnowDepthMaximumWithDate => Snow::class,
            self::SnowCover => SnowCover::class,
            self::CloudCoverMean => Cloud::class,
            self::Sunshine => Sunshine::class,
            self::Radiation => Radiation::class,
            self::DroughtIndex => DroughtIndex::class,
            self::EvaporationPotentialMakkink, self::EvaporationPotentialPenman => EvaporationPotential::class,
            self::LeafMoisture => LeafMoisture::class,
            self::NumberOfColdDays, self::NumberOfIceDays, self::NumberOfFrostDays, self::NumberOfTropicalDays,
            self::NumberOfSummerDays, self::NumberOfHeatingDaysDenmark, self::NumberOfHeatingDaysGreenland,
            self::NumberOfWindyDays, self::NumberOfStormyDays, self::NumberOfStormDays, self::NumberOfHurricaneDays,
            self::NumberOfDaysWithPrecipitation, self::NumberOfDaysWithPrecipitationUnder10, self::NumberOfDaysWithPrecipitationOver10,
            self::NumberOfDaysWithSnowCover, self::NumberOfClearDays, self::NumberOfCloudyDays => Statistical::class,
        };
    }
}
