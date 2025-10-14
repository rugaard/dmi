<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use DateTime;
use DateTimeZone;
use Exception;
use Rugaard\DMI\Support\Attributes\BoundingBox as HasBoundingBox;
use Rugaard\DMI\Support\Attributes\CreatedTimestamp as HasCreatedTimestamp;
use Rugaard\DMI\Support\Attributes\Location as HasLocation;
use Rugaard\DMI\Support\Attributes\STAC as HasSTAC;
use Rugaard\DMI\Support\FromGeoJson;

/**
 * Class Radar.
 */
abstract class Radar extends DTO
{
    use FromGeoJson, HasBoundingBox, HasLocation, HasCreatedTimestamp, HasSTAC;
    /**
     * Radar data ID.
     *
     * @var string
     */
    public string $id;

    /**
     * Timestamp of scan.
     *
     * @var DateTime
     */
    public DateTime $scannedAt;

    /**
     * Timestamp of creation in DMI database.
     *
     * @var DateTime
     */
    public DateTime $createdAt;

    /**
     * Set timestamp of scan.
     *
     * @param string $datetime
     * @return $this
     */
    protected function setDatetime(string $datetime): self
    {
        try {
            $this->scannedAt = (new DateTime($datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC'));
        } catch (Exception) {
            //
        }
        return $this;
    }
}
