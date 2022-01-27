<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Observations;

use Rugaard\DMI\DTO\Measurement\Cloud;
use Rugaard\DMI\DTO\Measurement\Humidity;
use Rugaard\DMI\DTO\Measurement\LeafMoisture;
use Rugaard\DMI\DTO\Measurement\Pressure;
use Rugaard\DMI\DTO\Measurement\Precipitation;
use Rugaard\DMI\DTO\Measurement\Radiation;
use Rugaard\DMI\DTO\Measurement\Sunshine;
use Rugaard\DMI\DTO\Measurement\Snow;
use Rugaard\DMI\DTO\Measurement\Temperature;
use Rugaard\DMI\DTO\Measurement\Visibility;
use Rugaard\DMI\DTO\Measurement\Weather;
use Rugaard\DMI\DTO\Measurement\Wind;
use Rugaard\DMI\DTO\Observations;

/**
 * Class Meteorological.
 *
 * @package Rugaard\DMI\DTO\Observations
 */
class Meteorological extends Observations
{
    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        foreach ($data as $observation) {
            switch ($observation['properties']['parameterId']) {
                // Weather condition (descriptive)
                case 'weather':
                    $this->data->push(new Weather($observation));
                    break;
                // Temperatures
                case 'temp_dry':
                case 'temp_max_past1h':
                case 'temp_mean_past1h':
                case 'temp_min_past1h':
                case 'temp_max_past12h':
                case 'temp_min_past12h':
                case 'temp_grass':
                case 'temp_grass_max_past1h':
                case 'temp_grass_mean_past1h':
                case 'temp_grass_min_past1h':
                case 'temp_soil':
                case 'temp_soil_max_past1h':
                case 'temp_soil_mean_past1h':
                case 'temp_soil_min_past1h':
                case 'temp_dew':
                    $this->data->push(new Temperature($observation));
                    break;
                // Humidity
                case 'humidity':
                case 'humidity_past1h':
                    $this->data->push(new Humidity($observation));
                    break;
                // Pressure
                case 'pressure':
                case 'pressure_at_sea':
                    $this->data->push(new Pressure($observation));
                    break;
                // Wind
                case 'wind_dir':
                case 'wind_dir_past1h':
                case 'wind_gust_always_past1h':
                case 'wind_max':
                case 'wind_min_past1h':
                case 'wind_max_per10min_past1h':
                case 'wind_speed':
                case 'wind_speed_past1h':
                    $this->data->push(new Wind($observation));
                    break;
                // Precipitation
                case 'precip_past1h':
                case 'precip_past10min':
                case 'precip_past1min':
                case 'precip_past24h':
                case 'precip_dur_past10min':
                case 'precip_dur_past1h':
                    $this->data->push(new Precipitation($observation));
                    break;
                // Snow
                case 'snow_depth_man':
                case 'snow_cover_man':
                    $this->data->push(new Snow($observation));
                    break;
                // Visibility
                case 'visibility':
                case 'visib_mean_last10min':
                    $this->data->push(new Visibility($observation));
                    break;
                // Cloud
                case 'cloud_cover':
                case 'cloud_height':
                    $this->data->push(new Cloud($observation));
                    break;
                // Radiation
                case 'radia_glob':
                case 'radia_glob_past1h':
                    $this->data->push(new Radiation($observation));
                    break;
                // Sunshine
                case 'sun_last10min_glob':
                case 'sun_last1h_glob':
                    $this->data->push(new Sunshine($observation));
                    break;
                // Leaf moisture
                case 'leav_hum_dur_past10min':
                case 'leav_hum_dur_past1h':
                    $this->data->push(new LeafMoisture($observation));
                    break;
            }
        }
    }
}
