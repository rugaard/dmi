<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use DateTime;
use Rugaard\DMI\Support\DateTimePeriod;
use Rugaard\DMI\Contracts\Location;

/**
 * Class AbstractStation.
 *
 * @abstract
 * @package Rugaard\DMI\Abstracts
 */
abstract class AbstractStation extends AbstractDTO
{
    /**
     * Stations UUID.
     *
     * @var string
     */
    public string $id;

    /**
     * Stations ID.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Stations name.
     *
     * @var string
     */
    public string $name;

    /**
     * Owner of station.
     *
     * @var string
     */
    public string $owner;

    /**
     * Station type.
     *
     * @var string
     */
    public string $type;

    /**
     * Country where station is located.
     *
     * @var string
     */
    public string $country;

    /**
     * Whether station is still active or not.
     *
     * @var boolean
     */
    public bool $isActive;

    /**
     * Location of station.
     *
     * @var \Rugaard\DMI\Contracts\Location|null
     */
    public ?Location $location;

    /**
     * Period of where station is operational.
     *
     * @var \Rugaard\DMI\Support\DateTimePeriod
     */
    public DateTimePeriod $operational;

    /**
     * Period of where station data is valid.
     *
     * @var \Rugaard\DMI\Support\DateTimePeriod
     */
    public DateTimePeriod $valid;

    /**
     * Timestamp of when station was created in DMI database.
     *
     * @var \DateTime
     */
    public DateTime $created;

    /**
     * Timestamp of when station was last updated in DMI database.
     *
     * @var \DateTime
     */
    public DateTime $updated;
}
