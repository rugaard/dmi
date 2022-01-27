<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Length\Centimeter;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Snow.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Snow extends Measurement
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
             ->setUnit(new Centimeter)
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
            case 'snow_depth':
                $this->setType('depth')->setDescription('Snow depth');
                break;
            case 'max_snow_depth':
                $this->setType('depth_max')->setDescription('Maximum snow depth');
                break;
            case 'snow_cover':
                $this->setType('cover')->setDescription('Snow cover')->setUnit(new Percentage);
                break;
        }
    }
}
