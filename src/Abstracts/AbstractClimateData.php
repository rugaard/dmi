<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use DateTime;
use Rugaard\DMI\Contracts\Location;
use Rugaard\DMI\Support\DateTimePeriod;
use Rugaard\DMI\Types\ClimateType;

/**
 * Class AbstractClimateData.
 *
 * @package Rugaard\DMI\Abstracts
 */
abstract class AbstractClimateData extends AbstractDTO
{
    /**
     * Data UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * ID of station data belongs to.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Type of climate data.
     *
     * @var \Rugaard\DMI\Types\ClimateType
     */
    public ClimateType $type;

    /**
     * Type of timespan value represents.
     *
     * Values: "hour", "day", "month" and "year".
     *
     * @var string
     */
    public string $timeResolution;

    /**
     * Time period value is based on.
     *
     * @var \Rugaard\DMI\Support\DateTimePeriod
     */
    public DateTimePeriod $timePeriod;

    /**
     * Number of values used to calculate the value of a station value.
     *
     * E.g. the number of hourly values used to calculate the corresponding daily value,
     * or number of daily values used to calculate the corresponding monthly value.
     *
     * Will not be set for "hour" based values.
     *
     * @var int|null
     */
    public ?int $basedOnNumberOfValues;

    /**
     * Value of data.
     *
     * @var string|int|float
     */
    public string|int|float $value;

    /**
     * Unit of data value.
     *
     * @var \Rugaard\DMI\Abstracts\AbstractUnit
     */
    public AbstractUnit $unit;

    /**
     * Location of station.
     *
     * @var \Rugaard\DMI\Contracts\Location|null
     */
    public ?Location $location;

    /**
     * Whether climate data has been manually controlled
     * by one of DMIs climatologists or not.
     *
     * @var bool
     */
    public bool $isQualityControlled = false;

    /**
     * Whether value is considered valid by
     * DMIs climatologists or not.
     *
     * @var bool
     */
    public bool $isConsideredValid = false;

    /**
     * Timestamp of data calculation.
     *
     * @var \DateTime
     */
    public DateTime $calculatedAt;

    /**
     * Timestamp of creation in DMIs database.
     *
     * @var \DateTime
     */
    public DateTime $createdAt;
}
