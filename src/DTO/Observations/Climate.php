<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Observations;

use Rugaard\DMI\DTO\Measurement\QualityControlled\Cloud;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Humidity;
use Rugaard\DMI\DTO\Measurement\QualityControlled\LeafMoisture;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Precipitation;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Pressure;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Radiation;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Snow;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Statistic;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Sunshine;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Temperature;
use Rugaard\DMI\DTO\Measurement\QualityControlled\Wind;
use Rugaard\DMI\DTO\Observations;

/**
 * Class Climate.
 *
 * @package Rugaard\DMI\DTO\Observations
 */
class Climate extends Observations
{
    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        foreach ($data as $observation) {
            try {
                switch ($observation['properties']['parameterId']) {
                    // Temperatures
                    case 'mean_temp':
                    case 'mean_daily_max_temp':
                    case 'max_temp_w_date':
                    case 'max_temp_12h':
                    case 'mean_daily_min_temp':
                    case 'min_temp':
                    case 'min_temperature_12h':
                    case 'temp_grass':
                    case 'temp_soil_10':
                    case 'temp_soil_30':
                        $this->data->push(new Temperature($observation));
                        break;
                    // Humidity
                    case 'mean_relative_hum':
                    case 'max_relative_hum':
                    case 'min_relative_hum':
                        $this->data->push(new Humidity($observation));
                        break;
                    // Pressure
                    case 'mean_pressure':
                    case 'max_pressure':
                    case 'min_pressure':
                    case 'mean_vapour_pressure':
                    case 'vapour_pressure_deficit_mean':
                        $this->data->push(new Pressure($observation));
                        break;
                    // Wind
                    case 'mean_wind_speed':
                    case 'max_wind_speed_3sec':
                    case 'max_wind_speed_10min':
                    case 'mean_wind_dir':
                    case 'mean_wind_dir_min0':
                        $this->data->push(new Wind($observation));
                        break;
                    // Precipitation
                    case 'acc_precip':
                    case 'acc_precip_past12h':
                    case 'acc_precip_past24h':
                    case 'max_precip_30m':
                    case 'max_precip_24h':
                        $this->data->push(new Precipitation($observation));
                        break;
                    // Snow
                    case 'snow_depth':
                    case 'max_snow_depth':
                    case 'snow_cover':
                        $this->data->push(new Snow($observation));
                        break;
                    // Sunshine
                    case 'bright_sunshine':
                        $this->data->push(new Sunshine($observation));
                        break;
                    // Radiation
                    case 'mean_radiation':
                        $this->data->push(new Radiation($observation));
                        break;
                    // Cloud
                    case 'mean_cloud_cover':
                        $this->data->push(new Cloud($observation));
                        break;
                    // Leaf moisture
                    case 'leaf_moisture':
                        $this->data->push(new LeafMoisture($observation));
                        break;
                    // Statistical
                    case 'no_ice_days':
                    case 'no_summer_days':
                    case 'no_cold_days':
                    case 'no_frost_days':
                    case 'no_tropical_nights':
                    case 'acc_heating_degree_days_17':
                    case 'acc_heating_degree_days_19':
                    case 'no_windy_days':
                    case 'no_stormy_days':
                    case 'no_days_w_storm':
                    case 'no_days_w_hurricane':
                    case 'no_days_acc_precip_01':
                    case 'no_days_acc_precip_1':
                    case 'no_days_acc_precip_10':
                    case 'no_days_snow_cover':
                    case 'no_clear_days':
                    case 'no_cloudy_days':
                        $this->data->push(new Statistic($observation));
                        break;
                }
            } catch (\Throwable $e) {
                dd($e, $observation);
            }
        }
    }
}
