<?php

namespace Rugaard\DMI\DTO\Lightning;

use DateTime;
use Rugaard\DMI\Abstracts\AbstractDTO;
use Rugaard\DMI\Abstracts\AbstractUnit;
use Rugaard\DMI\DTO\Location;
use Rugaard\DMI\Units\Energy\Kiloampere;
use Tightenco\Collect\Support\Collection;

/**
 * Class SensorData.
 *
 * @package Rugaard\DMI\DTO\Lightning
 */
class SensorData extends AbstractDTO
{
    /**
     * SensorData UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * Sensor ID.
     *
     * @var string
     */
    public string $sensorId;

    /**
     * Number of strokes.
     *
     * @var int
     */
    public int $strokes;

    /**
     * Strength of lightning.
     *
     * @var float
     */
    public float $value;

    /**
     * Unit of lightning value.
     *
     * @var \Rugaard\DMI\Abstracts\AbstractUnit
     */
    public AbstractUnit $unit;

    /**
     * Direction the station registered the lightning stroke.
     *
     * @var float
     */
    public float $direction;

    /**
     * Location of lightning.
     *
     * @var \Rugaard\DMI\DTO\Location|null
     */
    public ?Location $location;

    /**
     * Time of observation.
     *
     * @var \DateTime
     */
    public DateTime $observed;

    /**
     * Time of creation in DMI database.
     *
     * @var \DateTime
     */
    public DateTime $created;

    /**
     * Lightning constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Kiloampere();
    }
}
