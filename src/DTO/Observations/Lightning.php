<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Observations;

use Rugaard\DMI\DTO\Measurement\Lightning as LightningMeasurement;
use Rugaard\DMI\DTO\Measurement\LightningSensor;
use Rugaard\DMI\DTO\Observations;

/**
 * Class Lightning.
 *
 * @package Rugaard\DMI\DTO\Observations
 */
class Lightning extends Observations
{
    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        foreach ($data as $observation) {
            if (isset($observation['properties']['sensorId'])) {
                $this->data->push(new LightningSensor($observation));
            } else {
                $this->data->push(new LightningMeasurement($observation));
            }
        }
    }
}
