<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Energy\MillijoulePerSquareMeter;
use Rugaard\DMI\Units\Energy\WattPerSquareMeter;

/**
 * Class Radiation.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Radiation extends Measurement
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
             ->setType('mean')
             ->setDescription('Mean radiation (spectral range: 305-2800nm)')
             ->setValue($data['properties']['value'])
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setTimespan($data['properties']['timeResolution'])
             ->setTimePeriod($data['properties']['from'], $data['properties']['to'])
             ->setCalculatedAt($data['properties']['calculatedAt'])
             ->setValid((bool) $data['properties']['validity'])
             ->setManuallyVerified($data['properties']['qcStatus'] === 'manual');

        if ($this->getTimespan() === 'hour') {
            $this->setUnit(new WattPerSquareMeter);
        } else {
            $this->setUnit(new MillijoulePerSquareMeter)->setNumberOfValues($data['properties']['noValuesInCalculation']);
        }
    }
}
