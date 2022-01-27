<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement\QualityControlled;

use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasParameterId;
use Rugaard\DMI\Attributes\HasQualityControl;
use Rugaard\DMI\Attributes\HasStationId;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Cloud.
 *
 * @package Rugaard\DMI\DTO\Measurement\QualityControlled
 */
class Cloud extends Measurement
{
    use HasLocation, HasParameterId, HasQualityControl, HasStationId, HasUnit;

    /**
     * Observation method.
     *
     * @var string|null
     */
    protected ?string $method;

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
             ->setType('mean_cover')
             ->setDescription('The fraction of the sky covered by cloud of any type or height above the ground')
             ->setValue($this->oktasToPercentage($data['properties']['value']))
             ->setUnit(new Minute)
             ->setStationId($data['properties']['stationId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setMethod($data['properties']['cloudCoverMethod'] ?? null)
             ->setTimespan($data['properties']['timeResolution'])
             ->setTimePeriod($data['properties']['from'], $data['properties']['to'])
             ->setCalculatedAt($data['properties']['calculatedAt'])
             ->setValid((bool) $data['properties']['validity'])
             ->setManuallyVerified($data['properties']['qcStatus'] === 'manual');

        if ($this->getTimespan() !== 'hour') {
            $this->setNumberOfValues($data['properties']['noValuesInCalculation']);
        }
    }

    /**
     * Set cloud cover observation method.
     *
     * @param string|null $method
     * @return $this
     */
    public function setMethod(?string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * Get cloud cover observation method.
     *
     * @return string|null
     */
    public function getMethod():? string
    {
        return $this->method;
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
