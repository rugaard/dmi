<?php

declare(strict_types=1);

namespace Rugaard\DMI\Types;

use Rugaard\DMI\DTO\Meteorological\Cloud\Cloud;
use Rugaard\DMI\DTO\Meteorological\Cloud\CloudHeight;
use Rugaard\DMI\DTO\Meteorological\Humidity;
use Rugaard\DMI\DTO\Meteorological\LeafMoisture;
use Rugaard\DMI\DTO\Meteorological\Precipitation\Precipitation;
use Rugaard\DMI\DTO\Meteorological\Precipitation\PrecipitationDuration;
use Rugaard\DMI\DTO\Meteorological\Pressure;
use Rugaard\DMI\DTO\Meteorological\Radiation;
use Rugaard\DMI\DTO\Meteorological\Snow\Snow;
use Rugaard\DMI\DTO\Meteorological\Snow\SnowCover;
use Rugaard\DMI\DTO\Meteorological\Sunshine;
use Rugaard\DMI\DTO\Meteorological\Temperature;
use Rugaard\DMI\DTO\Meteorological\Visibility;
use Rugaard\DMI\DTO\Meteorological\WeatherCondition;
use Rugaard\DMI\DTO\Meteorological\Wind\WindDirection;
use Rugaard\DMI\DTO\Meteorological\Wind\Wind;

/**
 * Enum MeteorologicalType.
 *
 * @package Rugaard\DMI\Types
 * @return string
 */
enum MeteorologicalType: string
{
    /**
     * Present weather condition.
     *
     * Update interval: 10 min.
     */
    case WeatherCondition = 'weather';

    /**
     * Present air temperature measured 2 meters over terrain.
     *
     * Update interval: 10 min.
     */
    case TemperatureAir = 'temp_dry';

    /**
     * Latest hour minimum air temperature measured 2 meters over terrain.
     *
     * Update interval: Hourly
     */
    case TemperatureMinLatestHour = 'temp_min_past1h';

    /**
     * Latest hour mean air temperature measured 2 meters over terrain.
     *
     * Update interval: Hourly
     */
    case TemperatureMeanLatestHour = 'temp_mean_past1h';

    /**
     * Latest hour maximum air temperature measured 2 meters over terrain.
     *
     * Update interval: Hourly
     */
    case TemperatureMaxLatestHour = 'temp_max_past1h';

    /**
     * Latest 12 hours minimum air temperature measured 2 meters above ground.
     *
     * Update interval: 0600 and 1800 UTC.
     */
    case TemperatureMinLatest12Hours = 'temp_min_past12h';

    /**
     * Latest 12 hours maximum air temperature measured 2 meters above ground.
     *
     * Update interval: 0600 and 1800 UTC.
     */
    case TemperatureMaxLatest12Hours = 'temp_max_past12h';

    /**
     * Present dew point temperature measured 2 meters over terrain.
     *
     * Update interval: 10 min.
     */
    case TemperatureDewPoint = 'temp_dew';

    /**
     * Present air temperature measured at grass height (5-20 cm. over terrain).
     *
     * Update interval: 10 min.
     */
    case TemperatureGround = 'temp_grass';

    /**
     * Latest hour minimum air temperature measured at grass height (5-20 cm. over terrain).
     *
     * Update interval: Hourly
     */
    case TemperatureGroundMinLatestHour = 'temp_grass_min_past1h';

    /**
     * Latest hour mean air temperature measured at grass height (5-20 cm. over terrain).
     *
     * Update interval: Hourly
     */
    case TemperatureGroundMeanLatestHour = 'temp_grass_mean_past1h';

    /**
     * Latest hour maximum air temperature measured at grass height (5-20 cm. over terrain).
     *
     * Update interval: Hourly
     */
    case TemperatureGroundMaxLatestHour = 'temp_grass_max_past1h';

    /**
     * Present temperature measured at a depth of 10 cm.
     *
     * Update interval: 10 min.
     */
    case TemperatureSoil = 'temp_soil';

    /**
     * Latest hour minimum temperature measured at a depth of 10 cm.
     *
     * Update interval: Hourly
     */
    case TemperatureSoilMinLatestHour = 'temp_soil_min_past1h';

    /**
     * Latest hour mean temperature measured at a depth of 10 cm.
     *
     * Update interval: Hourly
     */
    case TemperatureSoilMeanLatestHour = 'temp_soil_mean_past1h';

    /**
     * Latest hour maximum temperature measured at a depth of 10 cm.
     *
     * Update interval: Hourly
     */
    case TemperatureSoilMaxLatestHour = 'temp_soil_max_past1h';

    /**
     * Present relative humidity measured 2 meters over terrain.
     *
     * Update interval: 10 min.
     */
    case Humidity = 'humidity';

    /**
     * Latest hour mean for relative humidity measured 2 meters over terrain.
     *
     * Update interval: Hourly
     */
    case HumidityLatestHour = 'humidity_past1h';

    /**
     * Atmospheric pressure at station level.
     *
     * Update interval: 10 min.
     */
    case Pressure = 'pressure';

    /**
     * Atmospheric pressure reduced to mean sea level.
     *
     * Update interval: 10 min.
     */
    case PressureSeaLevel = 'pressure_at_sea';

    /**
     * Latest 10 minutes mean wind direction measured 10 meters over terrain ("0" means calm).
     *
     * Update interval: 10 min.
     */
    case WindDirection = 'wind_dir';

    /**
     * Latest hour mean wind direction measured 10 meters over terrain.
     *
     * Update interval: Hourly
     */
    case WindDirectionLatestHour = 'wind_dir_past1h';

    /**
     * Latest 10 minutes mean wind speed measured 10 meters over terrain.
     *
     * Update interval: 10 min.
     */
    case WindSpeed = 'wind_speed';

    /**
     * Latest hour mean wind speed measured 10 meters over terrain.
     *
     * Update interval: Hourly
     */
    case WindSpeedLatestHour = 'wind_speed_past1h';

    /**
     * Latest 10 minutes lowest 3 seconds mean wind speed measured 10 meters over terrain.
     *
     * Update interval: 10 min.
     */
    case WindGustMin = 'wind_min';

    /**
     * Latest hour lowest 3 second mean wind speed measured 10 meters over terrain.
     *
     * Update interval: Hourly
     */
    case WindGustMinLatestHour = 'wind_min_past1h';

    /**
     * Latest 10 minutes highest 3 seconds mean wind speed measured 10 meters over terrain.
     *
     * Update interval: 10 min.
     */
    case WindGustMax = 'wind_max';

    /**
     * Latest hour highest 3 seconds mean wind speed measured 10 meters over terrain.
     *
     * Update interval: Hourly
     */
    case WindGustMaxLatestHour = 'wind_gust_always_past1h';

    /**
     * Maximum 10-minute average wind speed in the one-hour period preceding the time of observation.
     *
     * Update interval: Hourly
     */
    case WindGustMaxPrecedingHour = 'wind_max_per10min_past1h';

    /**
     * Accumulated precipitation in the latest 10 minutes.
     *
     * Update interval: 10 min.
     */
    case PrecipitationAmount = 'precip_past10min';

    /**
     * Data is sent to from the rain gauge to the DMI every 10 minutes,
     * if it has rained within the 10 min. period.
     * No data is sent, if it hasn't rained within the 10 min. period.
     *
     * The minutes, where it has rained, will show, how much it has rained during
     * each of the minutes in question, whereas the minutes, where it didn't rain
     * will be shown as '0'.
     *
     * Update interval: 10 min.
     */
    case PrecipitationAmountMinutely = 'precip_past1min';

    /**
     * Accumulated precipitation in the lastest hour or the code -0,1,
     * which means "traces of precipitation, less than 0.1 mm.".
     *
     * Update interval: Hourly
     */
    case PrecipitationAmountHourly = 'precip_past1h';

    /**
     * Accumulated precipitation in the latest 24 hours or the code -0,1,
     * which means "traces of precipitation, less than 0.1 mm."
     *
     * Update interval: Daily
     */
    case PrecipitationAmountDaily = 'precip_past24h';

    /**
     * Number of minutes with precipitation in the lastest 10 minutes.
     *
     * Update interval: 10 min.
     */
    case PrecipitationDuration = 'precip_dur_past10min';

    /**
     * Number of minutes with precipitation in the lastest hour.
     *
     * Update interval: Hourly
     */
    case PrecipitationDurationLatestHour = 'precip_dur_past1h';

    /**
     * Snow depth (measured manually) or the code -1, which means "less than 0.5 cm."
     *
     * Update interval: Daily
     */
    case SnowDepth = 'snow_depth_man';

    /**
     * Snow cover (measured manually), specified as quarters of the earth covered.
     *
     * Update interval: Daily
     */
    case SnowCover = 'snow_cover_man';

    /**
     * Present visibility.
     *
     * Update interval: 10 min.
     */
    case Visibility = 'visibility';

    /**
     * Latest 10 minutes mean visibility.
     *
     * Update interval: 10 min.
     */
    case VisibilityMean = 'visib_mean_last10min';

    /**
     * The fraction of the sky covered by cloud of any type or height above the ground.
     *
     * Update interval: 10 min.
     */
    case CloudCover = 'cloud_cover';

    /**
     * Height to the lowest clouds.
     *
     * Update interval: 10 min.
     */
    case CloudHeight = 'cloud_height';

    /**
     * Mean intensity of global radiation in lastest 10 minutes.
     *
     * Update interval: 10 min.
     */
    case Radiation = 'radia_glob';

    /**
     * Mean intensity of global radiation in the lastest hour.
     *
     * Update interval: Hourly
     */
    case RadiationLatestHour = 'radia_glob_past1h';

    /**
     * Number of minutes with sunshine the lastest 10 minutes.
     *
     * Update interval: 10 min.
     */
    case Sunshine = 'sun_last10min_glob';

    /**
     * Number of minutes with sunshine the latest hour.
     *
     * Update interval: Hourly
     */
    case SunshineLatestHour = 'sun_last1h_glob';

    /**
     * Number of minutes with leaf moisture the latest 10 minutes.
     *
     * Update interval: 10 min.
     */
    case LeafMoisture = 'leav_hum_dur_past10min';

    /**
     * Number of minutes with leaf moisture the latest hour.
     *
     * Update interval: Hourly
     */
    case LeafMoistureLatestHour = 'leav_hum_dur_past1h';

    /**
     * Get description of meteorological type.
     *
     * @return string
     */
    public function description(): string
    {
        return match ($this) {
            self::WeatherCondition => 'Present weather condition',
            self::TemperatureAir => 'Present air temperature measured 2 meters over terrain',
            self::TemperatureMinLatestHour => 'Latest hour minimum air temperature measured 2 meters over terrain',
            self::TemperatureMeanLatestHour => 'Latest hour mean air temperature measured 2 meters over terrain',
            self::TemperatureMaxLatestHour => 'Latest hour maximum air temperature measured 2 meters over terrain',
            self::TemperatureMinLatest12Hours => 'Latest 12 hours minimum air temperature measured 2 meters above ground',
            self::TemperatureMaxLatest12Hours => 'Latest 12 hours maximum air temperature measured 2 meters above ground',
            self::TemperatureDewPoint => 'Present dew point temperature measured 2 meters over terrain',
            self::TemperatureGround => 'Present air temperature measured at grass height (5-20 cm. over terrain)',
            self::TemperatureGroundMinLatestHour => 'Latest hour minimum air temperature measured at grass height (5-20 cm. over terrain)',
            self::TemperatureGroundMeanLatestHour => 'Latest hour mean air temperature measured at grass height (5-20 cm. over terrain)',
            self::TemperatureGroundMaxLatestHour => 'Latest hour maximum air temperature measured at grass height (5-20 cm. over terrain)',
            self::TemperatureSoil => 'Present temperature measured at a depth of 10 cm.',
            self::TemperatureSoilMinLatestHour => 'Latest hour minimum temperature measured at a depth of 10 cm.',
            self::TemperatureSoilMeanLatestHour => 'Latest hour mean temperature measured at a depth of 10 cm.',
            self::TemperatureSoilMaxLatestHour => 'Latest hour maximum temperature measured at a depth of 10 cm.',
            self::Humidity => 'Present relative humidity measured 2 meters over terrain',
            self::HumidityLatestHour => 'Latest hour mean for relative humidity measured 2 meters over terrain',
            self::Pressure => 'Atmospheric pressure at station level',
            self::PressureSeaLevel => 'Atmospheric pressure reduced to mean sea level',
            self::WindDirection => 'Latest 10 minutes mean wind direction measured 10 meters over terrain ("0" means calm)',
            self::WindDirectionLatestHour => 'Latest hour mean wind direction measured 10 meters over terrain',
            self::WindSpeed => 'Latest 10 minutes mean wind speed measured 10 meters over terrain',
            self::WindSpeedLatestHour => 'Latest hour mean wind speed measured 10 meters over terrain',
            self::WindGustMin => 'Latest 10 minutes lowest 3 seconds mean wind speed measured 10 meters over terrain',
            self::WindGustMinLatestHour => 'Latest hour lowest 3 second mean wind speed measured 10 meters over terrain',
            self::WindGustMax => 'Latest 10 minutes highest 3 seconds mean wind speed measured 10 meters over terrain',
            self::WindGustMaxLatestHour => 'Latest hour highest 3 seconds mean wind speed measured 10 meters over terrain.',
            self::WindGustMaxPrecedingHour => 'Maximum 10-minute average wind speed in the one-hour period preceding the time of observation',
            self::PrecipitationAmount => 'Accumulated precipitation in the latest 10 minutes.',
            self::PrecipitationAmountMinutely => 'Data is sent to from the rain gauge to the DMI every 10 minutes, if it has rained within the 10 min. period. If it has not rained within the 10 min. period, no data is sent.' . "\n" . 'The minutes, where it has rained, will show, how much it has rained during each of the minutes in question, whereas the minutes, where it did not rain will be shown as "0"',
            self::PrecipitationAmountHourly => 'Accumulated precipitation in the lastest hour or the code -0,1, which means "traces of precipitation, less than 0.1 mm."',
            self::PrecipitationAmountDaily => 'Accumulated precipitation in the latest 24 hours or the code -0,1, which means "traces of precipitation, less than 0.1 mm."',
            self::PrecipitationDuration => 'Number of minutes with precipitation in the lastest 10 minutes',
            self::PrecipitationDurationLatestHour => 'Number of minutes with precipitation in the lastest hour',
            self::SnowDepth => 'Snow depth (measured manually) or the code -1, which means "less than 0.5 cm."',
            self::SnowCover => 'Snow cover (measured manually), specified as quarters of the earth covered',
            self::Visibility => 'Present visibility',
            self::VisibilityMean => 'Latest 10 minutes mean visibility',
            self::CloudCover => 'The fraction of the sky covered by cloud of any type or height above the ground',
            self::CloudHeight => 'Height to the lowest clouds',
            self::Radiation => 'Mean intensity of global radiation in lastest 10 minutes',
            self::RadiationLatestHour => 'Mean intensity of global radiation in the lastest hour',
            self::Sunshine => 'Number of minutes with sunshine the lastest 10 minutes',
            self::SunshineLatestHour => 'Number of minutes with sunshine the latest hour',
            self::LeafMoisture => 'Number of minutes with leaf moisture the latest 10 minutes',
            self::LeafMoistureLatestHour => 'Number of minutes with leaf moisture the latest hour',
        };
    }

    /**
     * Get class namespace of matching meteorological type.
     *
     * @return string
     */
    public function type(): string
    {
        return match ($this) {
            self::WeatherCondition => WeatherCondition::class,
            self::TemperatureAir, self::TemperatureMinLatestHour, self::TemperatureMeanLatestHour, self::TemperatureMaxLatestHour, self::TemperatureMinLatest12Hours, self::TemperatureMaxLatest12Hours,
            self::TemperatureDewPoint, self::TemperatureGround, self::TemperatureGroundMinLatestHour, self::TemperatureGroundMeanLatestHour, self::TemperatureGroundMaxLatestHour,
            self::TemperatureSoil, self::TemperatureSoilMinLatestHour, self::TemperatureSoilMeanLatestHour, self::TemperatureSoilMaxLatestHour => Temperature::class,
            self::Humidity, self::HumidityLatestHour => Humidity::class,
            self::Pressure, self::PressureSeaLevel => Pressure::class,
            self::WindDirection, self::WindDirectionLatestHour => WindDirection::class,
            self::WindSpeed, self::WindSpeedLatestHour, self::WindGustMin, self::WindGustMinLatestHour,
            self::WindGustMax, self::WindGustMaxLatestHour, self::WindGustMaxPrecedingHour => Wind::class,
            self::PrecipitationAmount, self::PrecipitationAmountMinutely, self::PrecipitationAmountHourly, self::PrecipitationAmountDaily => Precipitation::class,
            self::PrecipitationDuration, self::PrecipitationDurationLatestHour => PrecipitationDuration::class,
            self::SnowDepth => Snow::class,
            self::SnowCover => SnowCover::class,
            self::Visibility, self::VisibilityMean => Visibility::class,
            self::CloudCover => Cloud::class,
            self::CloudHeight => CloudHeight::class,
            self::Sunshine, self::SunshineLatestHour => Sunshine::class,
            self::Radiation, self::RadiationLatestHour => Radiation::class,
            self::LeafMoisture, self::LeafMoistureLatestHour => LeafMoisture::class,
        };
    }
}
