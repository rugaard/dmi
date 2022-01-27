<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Energy\WattPerSquareMeter;

/**
 * Class Radiation.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Radiation extends Measurement
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
             ->setUnit(new WattPerSquareMeter)
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'radia_glob':
                $this->setType('latest')->setDescription('Latest 10 minutes global radiation mean intensity.');
                break;
            // Hourly
            case 'radia_glob_past1h':
                $this->setType('hourly')->setDescription('Mean intensity of global radiation in the latest hour.');
                break;
        }
    }
}
