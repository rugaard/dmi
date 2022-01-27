<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Station;

use DateTime;
use Rugaard\DMI\DTO\Station;

/**
 * Class Lightning.
 *
 * @package Rugaard\DMI\DTO\Station
 */
class Lightning extends Station
{
    /**
     * Sensor ID.
     *
     * @var string
     */
    protected string $sensorId;

    /**
     * Timestamp of last heartbeat.
     *
     * @var \DateTime
     */
    protected DateTime $lastHeartbeat;

    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        parent::parse($data);

        $this->setSensorId($data['properties']['sensorId'])
             ->setLastHeartbeat($data['properties']['lastHeartbeat']);
    }

    /**
     * Set sensor ID.
     *
     * @param string $sensorId
     * @return $this
     */
    public function setSensorId(string $sensorId): self
    {
        $this->sensorId = $sensorId;
        return $this;
    }

    /**
     * Get sensor ID.
     *
     * @return string
     */
    public function getSensorId(): string
    {
        return $this->sensorId;
    }

    /**
     * Set last heartbeat timestamp.
     *
     * @param string $timestamp
     * @return $this
     */
    public function setLastHeartbeat(string $timestamp): self
    {
        $this->lastHeartbeat = date_create($timestamp);
        return $this;
    }

    /**
     * Get timestamp of last heartbeat.
     *
     * @return \DateTime
     */
    public function getLastHeartbeat(): DateTime
    {
        return $this->lastHeartbeat;
    }
}
