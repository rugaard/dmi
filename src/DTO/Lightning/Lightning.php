<?php

namespace Rugaard\DMI\DTO\Lightning;

use DateTime;
use Rugaard\DMI\Abstracts\AbstractDTO;
use Rugaard\DMI\Abstracts\AbstractUnit;
use Rugaard\DMI\DTO\Location;
use Rugaard\DMI\Types\LightningType;
use Rugaard\DMI\Units\Energy\Kiloampere;
use Tightenco\Collect\Support\Collection;

/**
 * Class Lightning.
 *
 * @package Rugaard\DMI\DTO\Lightning
 */
class Lightning extends AbstractDTO
{
    /**
     * Lightning UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * Type of lightning.
     *
     * @var \Rugaard\DMI\Types\LightningType
     */
    public LightningType $type;

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
     * Location of lightning.
     *
     * @var \Rugaard\DMI\DTO\Location|null
     */
    public ?Location $location;

    /**
     * Array of ID's on sensors who registered
     * the lightning stroke.
     *
     * Note: List includes ID's on sensors not owned by DMI.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    public Collection $sensors;

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
