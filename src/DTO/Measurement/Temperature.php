<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Temperature\Celsius;

/**
 * Class Temperature.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Temperature extends Measurement
{
    use HasLocation, HasParameterId, HasObservedTimestamp, HasStationId, HasUnit;

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        parent::parse($data);

        $this->setParameterId($data['properties']['parameterId'] ?? null)
             ->setValue($data['properties']['value'])
             ->setUnit(new Celsius)
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'temp_dry':
                $this->setType('air')->setDescription('Present air temperature measured 2 meters over terrain.');
                break;
            case 'temp_dew':
                $this->setType('dew_point')->setDescription('Present dew point temperature measured 2 meters over terrain.');
                break;
            case 'temp_grass':
                $this->setType('ground')->setDescription('Present air temperature measured at grass height (5-20 cm. over terrain).');
                break;
            case 'temp_soil':
                $this->setType('soil')->setDescription('Present temperature measured at a depth of 10 cm.');
                break;
            case 'tw':
                $this->setType('water')->setDescription('Water temperature is a support value, which is required for calculating the sea level for a certain type of tide gauge. The water temperature is measured inside the harbor at a depth of a couple of meters relatively to the undisturbed sea surface. The measurement is therefore not standardized and should be used with this reservation.');
                break;
            // Hourly
            case 'temp_max_past1h':
                $this->setType('air_hourly_max')->setDescription('Latest hour\'s maximum air temperature measured 2 meters over terrain.');
                break;
            case 'temp_mean_past1h':
                $this->setType('air_hourly_mean')->setDescription('Latest hour\'s average air temperature measured 2 meters over terrain.');
                break;
            case 'temp_min_past1h':
                $this->setType('air_hourly_min')->setDescription('Latest hour\'s minimum air temperature measured 2 meters over terrain.');
                break;
            case 'temp_grass_max_past1h':
                $this->setType('ground_hourly_max')->setDescription('Latest hour\'s maximum air temperature measured at grass height (5-20 cm. over terrain).');
                break;
            case 'temp_grass_mean_past1h':
                $this->setType('ground_hourly_mean')->setDescription('Latest hour\'s average air temperature measured at grass height (5-20 cm. over terrain).');
                break;
            case 'temp_grass_min_past1h':
                $this->setType('ground_hourly_min')->setDescription('Latest hour\'s minimum air temperature measured at grass height (5-20 cm. over terrain).');
                break;
            case 'temp_soil_max_past1h':
                $this->setType('soil_hourly_max')->setDescription('Latest hour\'s maximum temperature measured at a depth of 10 cm.');
                break;
            case 'temp_soil_mean_past1h':
                $this->setType('soil_hourly_mean')->setDescription('Latest hour\'s mean temperature measured at a depth of 10 cm.');
                break;
            case 'temp_soil_min_past1h':
                $this->setType('soil_hourly_min')->setDescription('Latest hour\'s minimum temperature measured at a depth of 10 cm.');
                break;
            // Twice a day.
            case 'temp_max_past12h':
                $this->setType('air_12h_max')->setDescription('Last 12 hours maximum air temperature measured 2 meters above ground. Measured at 0600 and 1800 UTC.');
                break;
            case 'temp_min_past12h':
                $this->setType('air_12h_min')->setDescription('Last 12 hours minimum air temperature measured 2 meters above ground. Measured at 0600 and 1800 UTC.');
                break;
            // Climate data
            case 'mean_temp':
                $this->setType('air_mean')->setDescription('Mean temperature.');
                break;
            case 'mean_daily_max_temp':
                $this->setType('air_daily_mean_max')->setDescription('Mean of daily maximum temperature.');
                break;
            case 'max_temp_w_date':
                $this->setType('air_max')->setDescription('Maximum temperature with associated date.');
                break;
            case 'max_temp_12h':
                $this->setType('air_12h_max')->setDescription('Maximum temperature within the last 12 hours.');
                break;
            case 'mean_daily_min_temp':
                $this->setType('air_daily_mean_min')->setDescription('Mean of daily minimum temperature.');
                break;
            case 'min_temp':
                $this->setType('air_min')->setDescription('Minimum temperature.');
                break;
            case 'min_temperature_12h':
                $this->setType('air_12h_min')->setDescription('Minimum temperature within 12 hours.');
                break;
            case 'temp_soil_10':
                $this->setType('soil_10cm')->setDescription('Temperature measured at a depth of 10 cm.');
                break;
            case 'temp_soil_30':
                $this->setType('soil_30cm')->setDescription('Temperature measured at a depth of 30 cm.');
                break;
        }
    }
}
