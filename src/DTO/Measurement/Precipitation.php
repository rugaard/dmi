<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Length\Millimeter;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Precipitation.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Precipitation extends Measurement
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
            case 'precip_past1min':
                $this->setType('amount_minutely')
                     ->setDescription('Accumulated precipitation in the latest minute.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new Millimeter);
                break;
            case 'precip_past10min':
                $this->setType('amount')
                     ->setDescription('Accumulated precipitation in the latest 10 minutes.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new Millimeter);
                break;
            case 'precip_dur_past10min':
                $this->setType('duration')
                     ->setDescription('Number of minutes with precipitation in the latest 10 minutes.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new Minute);
                break;
            // Hourly
            case 'precip_past1h':
                $this->setType('amount_hourly')
                     ->setDescription('Accumulated precipitation in the latest hour.')
                     ->setValue($data['properties']['value'] === '-0.1' ? '<0.1' : $data['properties']['value'])
                     ->setUnit(new Millimeter);
                break;
            case 'precip_dur_past1h':
                $this->setType('duration_hourly')
                     ->setDescription('Number of minutes with precipitation in the latest hour.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new Minute);
                break;
            // Daily
            case 'precip_past24h':
                $this->setType('amount_daily')
                     ->setDescription('Accumulated precipitation in the latest 24 hours.')
                     ->setValue($data['properties']['value'] === '-0.1' ? '<0.1' : $data['properties']['value'])
                     ->setUnit(new Millimeter);
                break;
        }
    }
}
