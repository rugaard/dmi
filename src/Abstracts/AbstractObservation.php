<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use DateTime;
use Rugaard\DMI\Contracts\Location;
use Rugaard\DMI\Types\MeteorologicalType;
use Rugaard\DMI\Types\OceanographicType;

/**
 * Class AbstractObservation.
 *
 * @package Rugaard\DMI\Abstracts
 */
abstract class AbstractObservation extends AbstractDTO
{
    /**
     * Observation UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * ID of station observation belongs to.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Type of observation.
     *
     * @var \Rugaard\DMI\Types\MeteorologicalType|\Rugaard\DMI\Types\OceanographicType
     */
    public MeteorologicalType|OceanographicType $type;

    /**
     * Value of observation.
     *
     * @var string|int|float
     */
    public string|int|float $value;

    /**
     * Unit of observed value.
     *
     * @var \Rugaard\DMI\Abstracts\AbstractUnit
     */
    public AbstractUnit $unit;

    /**
     * Location of observation.
     *
     * @var \Rugaard\DMI\Contracts\Location|null
     */
    public ?Location $location;

    /**
     * Time of observation.
     *
     * @var \DateTime
     */
    public DateTime $timestamp;
}
