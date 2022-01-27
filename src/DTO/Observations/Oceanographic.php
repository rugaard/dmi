<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Observations;

use Rugaard\DMI\DTO\Measurement\SeaLevel;
use Rugaard\DMI\DTO\Measurement\Temperature;
use Rugaard\DMI\DTO\Observations;

/**
 * Class Oceanographic.
 *
 * @package Rugaard\DMI\DTO\Observations
 */
class Oceanographic extends Observations
{
    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        foreach ($data as $observation) {
            switch ($observation['properties']['parameterId']) {
                // Temperature
                case 'tw':
                    $this->data->push(new Temperature($observation));
                    break;
                // Sea Level
                case 'sealev_dvr':
                case 'sealev_ln':
                case 'sea_reg':
                    $this->data->push(new SeaLevel($observation));
                    break;
            }
        }
    }
}
