<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Temperature\Celsius;

/**
 * Class Temperature.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Temperature extends Measurement
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
             ->setUnit(new Celsius)
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
            case 'mean_temp':
                $this->setType('mean')->setDescription('Mean temperature');
                break;
            case 'mean_daily_max_temp':
                $this->setType('mean_max_daily')->setDescription('Mean of daily maximum temperature');
                break;
            case 'max_temp_w_date':
                $this->setType('max')->setDescription('Maximum temperature');
                break;
            case 'max_temp_12h':
                $this->setType('max_12h')->setDescription('Maximum temperature within the last 12 hours');
                break;
            case 'mean_daily_min_temp':
                $this->setType('mean_min_daily')->setDescription('Mean of daily minimum temperature');
                break;
            case 'min_temp':
                $this->setType('min')->setDescription('Minimum temperature');
                break;
            case 'min_temperature_12h':
                $this->setType('min_12h')->setDescription('Minimum temperature within the last 12 hours');
                break;
            case 'temp_grass':
                $this->setType('ground')->setDescription('Air temperature measured at grass height (5-20 cm. over terrain)');
                break;
            case 'temp_soil_10':
                $this->setType('soil')->setDescription('Temperature measured at a depth of 10 cm.');
                break;
            case 'temp_soil_30':
                $this->setType('soil_deep')->setDescription('Temperature measured at a depth of 30 cm.');
                break;
        }
    }
}
