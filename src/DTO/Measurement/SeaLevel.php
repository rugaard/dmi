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

/**
 * Class Pressure.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class SeaLevel extends Measurement
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
             ->setUnit(new Centimeter)
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'sealev_dvr':
                $this->setType('dvr90')->setDescription('Sea level relative to DVR90 (Danish Vertical Reference 1990). Recommended when looking at data from DMI\'s stations after January 1st 1997.');
                break;
            case 'sealev_ln':
                $this->setType('local_zero')->setDescription('Sea level relative to local zero for the station. Recommended when looking at data from DMI\'s stations before Januar 1st 1997.');
                break;
            case 'sea_reg':
                $this->setType('registration')->setDescription('Sea level registration. Recommended when looking at data from Kystdirektoratet / Coastal Authority. Data fra the Coastal Authority is measured in DVR90.');
                break;
        }
    }
}
