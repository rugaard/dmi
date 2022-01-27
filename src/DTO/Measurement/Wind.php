<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Bearing;
use Rugaard\DMI\Units\Speed\MetersPerSecond;

/**
 * Class Wind.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Wind extends Measurement
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
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'wind_speed':
                $this->setType('speed')
                     ->setDescription('Latest 10 minutes mean wind speed measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_max':
                $this->setType('gust_max')
                     ->setDescription('Latest 10 minutes highest 3 seconds mean wind speed measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_min':
                $this->setType('gust_min')
                     ->setDescription('Latest 10 minutes lowest 3 seconds mean wind speed measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_dir':
                $this->setType('direction')
                     ->setDescription('Latest 10 minutes mean wind direction measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'] === '0' ? 'Calm' : $data['properties']['value']);
                break;
            // Hourly
            case 'wind_speed_past1h':
                $this->setType('speed_hourly')
                     ->setDescription('Latest hour\'s mean wind speed measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_gust_always_past1h':
                $this->setType('gust_hourly_max')
                     ->setDescription('Latest hour\'s highest 3 seconds mean wind speed measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_min_past1h':
                $this->setType('gust_hourly_min')
                     ->setDescription('Latest hour\'s lowest 3 second mean wind speed measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_max_per10min_past1h':
                $this->setType('gust_10min_hourly')
                     ->setDescription('Maximum 10-minute average wind speed in the one hour period preceding the time of observation.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'wind_dir_past1h':
                $this->setType('direction_hourly')
                     ->setDescription('Latest hour\'s mean wind direction measured 10 meters over terrain.')
                     ->setValue($data['properties']['value'] === '0' ? 'Calm' : $data['properties']['value'])
                     ->setUnit(new Bearing);
                break;
            // Climate data
            case 'mean_wind_speed':
                $this->setType('speed_mean')
                     ->setDescription('Mean wind speed.')
                      ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'max_wind_speed_3sec':
                $this->setType('speed_mean_3sec')
                     ->setDescription('Maximum wind speed (3 seconds average).')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'max_wind_speed_10min':
                $this->setType('speed_mean_10min')
                     ->setDescription('Maximum wind speed (10 minutes average).')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new MetersPerSecond);
                break;
            case 'mean_wind_dir':
                $this->setType('direction_mean')
                     ->setDescription('Mean wind direction.')
                     ->setValue($data['properties']['value'] === '0' ? 'Calm' : $data['properties']['value'])
                     ->setUnit(new Bearing);
                break;
            case 'mean_wind_dir_min0':
                $this->setType('direction_mean_0min')
                     ->setDescription('Mean wind direction (10 minutes average) at minute 0.')
                     ->setValue($data['properties']['value'] === '0' ? 'Calm' : $data['properties']['value'])
                     ->setUnit(new Bearing);
                break;
        }
    }
}
