<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Lightning;

use Rugaard\DMI\Abstracts\Observations\Lightning as LightningObservation;

/**
 * Class Sensor.
 */
class Sensor extends LightningObservation
{
    /**
     * Direction of lightning stroke from sensor.
     *
     * @var float
     */
    public float $direction;

    /**
     * ID of sensor.
     *
     * @var int
     */
    public int $sensorId;

    /**
     * Set direction of lightning stroke.
     *
     * @param string $direction
     * @return $this
     */
    public function setDirection(string $direction): self
    {
        $this->direction = (float) $direction;
        return $this;
    }

    /**
     * Set sensor ID.
     *
     * @param string $sensorId
     * @return $this
     */
    public function setSensorId(string $sensorId): self
    {
        $this->sensorId = (int) $sensorId;
        return $this;
    }
}
