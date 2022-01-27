<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Pressure\Hectopascal;
use Rugaard\DMI\Units\Pressure\Kilopascal;

/**
 * Class Pressure.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Pressure extends Measurement
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
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);

        switch ($data['properties']['parameterId']) {
            // 10 minutes
            case 'pressure':
                $this->setType('station')->setDescription('Atmospheric pressure at station level.')->setUnit(new Hectopascal);
                break;
            case 'pressure_at_sea':
                $this->setType('sea_level')->setDescription('Atmospheric pressure reduced to mean sea level.')->setUnit(new Hectopascal);
                break;
            // Climate data
            case 'mean_pressure':
                $this->setType('mean')->setDescription('Mean pressure.')->setUnit(new Hectopascal);
                break;
            case 'max_pressure':
                $this->setType('max')->setDescription('Maximum pressure.')->setUnit(new Hectopascal);
                break;
            case 'min_pressure':
                $this->setType('min')->setDescription('Minimum pressure.')->setUnit(new Hectopascal);
                break;
            case 'mean_vapour_pressure':
                $this->setType('vapour_mean')->setDescription('Mean vapour pressure.')->setUnit(new Hectopascal);
                break;
            case 'vapour_pressure_deficit_mean':
                $this->setType('vapour_mean_deficit')->setDescription('Mean vapour pressure deficit.')->setUnit(new Kilopascal);
                break;
        }
    }
}
