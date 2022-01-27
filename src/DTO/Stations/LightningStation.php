<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Stations;

use DateTime;
use Rugaard\DMI\Abstracts\AbstractStation;

/**
 * Class LightningStation.
 *
 * @package Rugaard\DMI\DTO\Stations
 */
class LightningStation extends AbstractStation
{
    /**
     * Sensor ID.
     *
     * @var string
     */
    public string $sensorId;

    /**
     * Timestamp of last heartbeat.
     *
     * @var \DateTime
     */
    public DateTime $lastHeartbeat;
}
