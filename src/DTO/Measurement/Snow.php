<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Length\Centimeter;
use Rugaard\DMI\Units\Length\Quarter;

/**
 * Class Snow.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Snow extends Measurement
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
            // Daily
            case 'snow_depth_man':
                $this->setType('depth')
                     ->setDescription('Snow depth (measured manually).')
                     ->setValue($data['properties']['value'] === '-1' ? '<0.5' : $data['properties']['value'])
                     ->setUnit(new Centimeter);
                break;
            case 'snow_cover_man':
                $this->setType('cover')
                     ->setDescription('Snow cover (measured manually), specified as quarters of the earth covered.')
                     ->setValue($data['properties']['value'])
                     ->setUnit(new Quarter);;
                break;
        }
    }
}
