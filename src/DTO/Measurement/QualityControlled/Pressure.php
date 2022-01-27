<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Percentage;
use Rugaard\DMI\Units\Pressure\Kilopascal;

/**
 * Class Pressure.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Pressure extends Measurement
{
    use HasLocation, HasParameterId, HasQualityControl, HasStationId, HasUnit;

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
             ->setTimespan($data['properties']['timeResolution'])
             ->setTimePeriod($data['properties']['from'], $data['properties']['to'])
             ->setCalculatedAt($data['properties']['calculatedAt'])
             ->setValid((bool) $data['properties']['validity'])
             ->setManuallyVerified($data['properties']['qcStatus'] === 'manual');

        if ($this->getTimespan() !== 'hour') {
            $this->setNumberOfValues($data['properties']['noValuesInCalculation']);
        }

        switch ($data['properties']['parameterId']) {
            case 'mean_pressure':
                $this->setType('mean')->setDescription('Mean pressure');
                break;
            case 'max_pressure':
                $this->setType('max')->setDescription('Maximum pressure');
                break;
            case 'min_pressure':
                $this->setType('min')->setDescription('Minimum pressure');
                break;
            case 'mean_vapour_pressure':
                $this->setType('vapour_mean')->setDescription('Mean vapour pressure');
                break;
            case 'vapour_pressure_deficit_mean':
                $this->setType('vapour_mean_deficit')->setDescription('Mean vapour pressure deficit')->setUnit(new Kilopascal);
                break;
        }
    }
}
