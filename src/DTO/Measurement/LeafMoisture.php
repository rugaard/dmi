<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class LeafMoisture.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class LeafMoisture extends Measurement
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

        $this->setValue($data['properties']['value'])
             ->setParameterId($data['properties']['parameterId'] ?? null)
             ->setValue($data['properties']['value'])
             ->setUnit(new Minute)
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'leav_hum_dur_past10min':
                $this->setType('latest')->setDescription('Number of minutes with leaf moisture the latest 10 minutes.');
                break;
            // Hourly
            case 'leav_hum_dur_past1h':
                $this->setType('hourly')->setDescription('Number of minutes with leaf moisture the latest hour.');
                break;
        }
    }
}
