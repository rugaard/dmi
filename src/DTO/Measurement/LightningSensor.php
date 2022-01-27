<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurement;

use DateTime;
use Rugaard\DMI\Attributes\HasLocation;
use Rugaard\DMI\Attributes\HasObservedTimestamp;
use Rugaard\DMI\Attributes\HasUnit;
use Rugaard\DMI\DTO\Measurement;
use Rugaard\DMI\Units\Energy\Kiloampere;

/**
 * Class LightningSensor.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class LightningSensor extends Measurement
{
    use HasLocation, HasObservedTimestamp, HasUnit;

    /**
     * Strokes attribute.
     *
     * @var float
     */
    protected float $strokes;

    /**
     * Bearing of where the lightning was sensed.
     *
     * @var float
     */
    protected float $direction;

    /**
     * Sensor station ID.
     *
     * @var string
     */
    protected string $sensorStationId;

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        parent::parse($data);

        $this->setValue($data['properties']['amp'])
             ->setUnit(new Kiloampere)
             ->setStrokes($data['properties']['strokes'])
             ->setDirection((float) $data['properties']['direction'])
             ->setSensorStationId($data['properties']['sensorId'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);
    }

    /**
     * Set bearing of where lightning was sensed.
     *
     * @param float $direction
     * @return $this
     */
    public function setDirection(float $direction): self
    {
        $this->direction = $direction;
        return $this;
    }

    /**
     * Get bearing of where lightning was sensed.
     *
     * @return float
     */
    public function getDirection(): float
    {
        return $this->direction;
    }

    /**
     * Set sensor station ID.
     *
     * @param string $sensorStationId
     * @return $this
     */
    public function setSensorStationId(string $sensorStationId): self
    {
        $this->sensorStationId = $sensorStationId;
        return $this;
    }

    /**
     * Get sensor station ID.
     *
     * @return string
     */
    public function getSensorStationId(): string
    {
        return $this->sensorStationId;
    }

    /**
     * Set number lightning strokes.
     *
     * @param float $strokes
     * @return $this
     */
    public function setStrokes(float $strokes): self
    {
        $this->strokes = $strokes;
        return $this;
    }

    /**
     * Get number of lightning strokes.
     *
     * @return float
     */
    public function getStrokes(): float
    {
        return $this->strokes;
    }
}
