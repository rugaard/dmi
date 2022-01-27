<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Time\Day;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Statistic.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Statistic extends Measurement
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
             ->setUnit(new Day)
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
            case 'no_ice_days':
                $this->setType('ice_days')->setDescription('Number of ice days (maximum temperature < 0°C)');
                break;
            case 'no_summer_days':
                $this->setType('summer_days')->setDescription('Number of summer days (maximum temperature > 25°C)');
                break;
            case 'no_cold_days':
                $this->setType('cold_days')->setDescription('Number of cold days (minimum temperature < -10 °C)');
                break;
            case 'no_frost_days':
                $this->setType('frost_days')->setDescription('Number of days with frost (minimum temperature < 0°C)');
                break;
            case 'no_tropical_nights':
                $this->setType('tropical_nights')->setDescription('Number of tropical nights (minimum temperature > 20°C)');
                break;
            case 'acc_heating_degree_days_17':
                $this->setType('heating_days_17')->setDescription('Accumulated heating degree days (17°C - mean temperature)');
                break;
            case 'acc_heating_degree_days_19':
                $this->setType('heating_days_19')->setDescription('Accumulated heating degree days (19°C - mean temperature)');
                break;
            case 'no_windy_days':
                $this->setType('windy_days')->setDescription('Number of windy days (mean wind speed >= 10.8m/s)');
                break;
            case 'no_stormy_days':
                $this->setType('stormy_days')->setDescription('Number of stormy days (mean wind speed >= 20.8m/s)');
                break;
            case 'no_days_w_storm':
                $this->setType('heavy_storm_days')->setDescription('Number of days with storm (mean wind speed >=24.5m/s)');
                break;
            case 'no_days_w_hurricane':
                $this->setType('hurricane_days')->setDescription('Number of days with hurricane (mean wind speed >=28.5m/s)');
                break;
            case 'no_days_acc_precip_01':
                $this->setType('precipitation_any')->setDescription('Number of days with accumulated precipitation >= 0.1mm');
                break;
            case 'no_days_acc_precip_1':
                $this->setType('precipitation_low')->setDescription('Number of days with accumulated precipitation >= 1mm');
                break;
            case 'no_days_acc_precip_10':
                $this->setType('precipitation_high')->setDescription('Number of days with accumulated precipitation >= 10mm');
                break;
            case 'no_days_snow_cover':
                $this->setType('snowy_days')->setDescription('Number of days with snow cover (> 50% covered)');
                break;
            case 'no_clear_days':
                $this->setType('clear_days')->setDescription('Number of clear days (mean cloud cover < 20%)');
                break;
            case 'no_cloudy_days':
                $this->setType('cloudy_days')->setDescription('Number of cloudy days (mean cloud cover > 80%)');
                break;
        }
    }
}
