<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Bearing;
use Rugaard\DMI\Units\Speed\MetersPerSecond;

/**
 * Class Wind.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Wind extends Measurement
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
            case 'mean_wind_speed':
                $this->setType('mean_speed')->setDescription('Mean wind speed')->setUnit(new MetersPerSecond);
                break;
            case 'max_wind_speed_3sec':
                $this->setType('max_speed_seconds')->setDescription('Maximum wind speed (3 seconds average)')->setUnit(new MetersPerSecond);
                break;
            case 'max_wind_speed_10min':
                $this->setType('max_speed_minutes')->setDescription('Maximum wind speed (10 minutes average)')->setUnit(new MetersPerSecond);
                break;
            case 'mean_wind_dir':
                $this->setType('mean_direction')->setDescription('Mean wind direction')->setUnit(new Bearing);
                break;
            case 'mean_wind_dir_min0':
                $this->setType('mean_direction_minutes')->setDescription('Mean wind direction (10 minutes average) at minute 0')->setUnit(new Bearing);
                break;
        }
    }
}
