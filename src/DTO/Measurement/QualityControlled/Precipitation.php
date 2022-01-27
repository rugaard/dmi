<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Length\Millimeter;

/**
 * Class Precipitation.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Precipitation extends Measurement
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
             ->setUnit(new Millimeter)
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
            case 'acc_precip':
                $this->setType('total')->setDescription('Accumulated precipitation');
                break;
            case 'acc_precip_past12h':
                $this->setType('total_12h')->setDescription('Accumulated precipitation during the past 12 hours');
                break;
            case 'acc_precip_past24h':
                $this->setType('total_24h')->setDescription('Accumulated precipitation during the past 24 hours');
                break;
            case 'max_precip_30m':
                $this->setType('max_intensity')->setDescription('Maximum 30 minutes intensity in 24 hours');
                break;
            case 'max_precip_24h':
                $this->setType('max_daily')->setDescription('Maximum 24-hour precipitation.');
                break;
        }
    }
}
