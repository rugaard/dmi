<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Humidity.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Humidity extends Measurement
{
    use HasParameterId, HasLocation, HasObservedTimestamp, HasStationId, HasUnit;

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
             ->setUnit(new Percentage)
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'humidity':
                $this->setType('latest')->setDescription('Present relative humidity measured 2 meters over terrain.');
                break;
            // Hourly
            case 'humidity_past1h':
                $this->setType('hourly')->setDescription('Latest hour\'s mean for relative humidity measured 2 meters over terrain.');
                break;
            // Climate data
            case 'mean_relative_hum':
                $this->setType('mean')->setDescription('Mean relative humidity.');
                break;
            case 'max_relative_hum':
                $this->setType('max')->setDescription('Maximum relative humidity.');
                break;
            case 'min_relative_hum':
                $this->setType('min')->setDescription('Minimum relative humidity.');
                break;
        }
    }
}
