<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Length\Meter;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Cloud.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Cloud extends Measurement
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
            // 10 minutes
            case 'cloud_cover':
                $this->setType('cover')
                     ->setDescription('The fraction of the sky covered by cloud of any type or height above the ground.')
                     ->setValue($this->oktasToPercentage($data['properties']['value']))
                     ->setUnit(new Percentage);
                break;
            case 'cloud_height':
                $this->setType('height')->setDescription('Height to the lowest clouds.')->setValue($data['properties']['value'])->setUnit(new Meter);
                break;
        }
    }

    /**
     * Convert oktas to percentage range.
     *
     * @param float $okta
     * @return string
     */
    private function oktasToPercentage(float $okta): string
    {
        switch ($okta) {
            case 0:
                return '0';
            case 10.0:
                return '0-18.75';
            case 25.0:
                return '18.75-31.25';
            case 40.0:
                return '31.25-43.75';
            case 50.0:
                return '43.75-56.25';
            case 60.0:
                return '56.25-68.75';
            case 75.0:
                return '68.75-81.25';
            case 90.0:
                return '81.25-100';
            case 100.0:
                return '100';
            case 112.0:
                return '>100';
        }
    }
}
