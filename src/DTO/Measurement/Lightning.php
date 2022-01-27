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
 * Class Lightning.
 *
 * @package Rugaard\DMI\DTO\Measurement
 */
class Lightning extends Measurement
{
    use HasLocation, HasObservedTimestamp, HasUnit;

    /**
     * Strokes attribute.
     *
     * @var float
     */
    protected float $strokes;

    /**
     * List of station ID's that sensed the lightning.
     *
     * @var array
     */
    protected array $sensorStationIds = [];

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
             ->setType(match ((int) $data['properties']['type']) {
                0, 1 => 'cloud-to-ground',
                2 => 'cloud-to-cloud'
             })
             ->setSensorStationIds($data['properties']['sensors'])
             ->setLocation($data['geometry']['type'], $data['geometry']['coordinates'])
             ->setObservedAt($data['properties']['observed']);
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

    /**
     * Set list of station ID's that sensed the lightning.
     *
     * @param string $sensorStationIds
     * @return $this
     */
    public function setSensorStationIds(string $sensorStationIds): self
    {
        $this->sensorStationIds = explode(',', $sensorStationIds);
        return $this;
    }

    /**
     * Get list of station ID's that sensed the lightning.
     *
     * @return array
     */
    public function getSensorStationIds(): array
    {
        return $this->sensorStationIds;
    }

    /**
     * Whether or not lightning was negative charged.
     *
     * @return bool
     */
    public function wasNegativeCharged(): bool
    {
        return $this->value < 0;
    }

    /**
     * Whether or not lightning was positive charged.
     *
     * @return bool
     */
    public function wasPositiveCharged(): bool
    {
        return $this->value >= 0;
    }
}
