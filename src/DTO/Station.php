<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use DateTime;
use Rugaard\DMI\Support\DateTimePeriod;
use Rugaard\DMI\Support\Distance;
use Rugaard\DMI\Support\Location;

/**
 * Class Station.
 *
 * @package Rugaard\DMI\DTO
 */
abstract class Station extends DTO
{
    /**
     * Station ID.
     *
     * @var string
     */
    protected string $id;

    /**
     * Station UUID.
     *
     * @var string
     */
    protected string $uuid;

    /**
     * Country where station is located.
     *
     * @var string
     */
    protected string $country;

    /**
     * Location of station.
     *
     * @var \Rugaard\DMI\Support\Location|null
     */
    protected ?Location $location = null;

    /**
     * Station name.
     *
     * @var string
     */
    protected string $name;

    /**
     * Owner of station.
     *
     * @var string
     */
    protected string $owner;

    /**
     * Station status.
     *
     * @var string
     */
    protected string $status;

    /**
     * Station type.
     *
     * @var string
     */
    protected string $type;

    /**
     * Timestamp of last station update.
     *
     * @var \DateTime|null
     */
    protected ?DateTime $updatedAt = null;

    /**
     * Period where station is operational.
     *
     * @var \Rugaard\DMI\Support\DateTimePeriod|null
     */
    protected ?DateTimePeriod $operating = null;

    /**
     * Period where station measurements are valid.
     *
     * @var \Rugaard\DMI\Support\DateTimePeriod|null
     */
    protected ?DateTimePeriod $valid = null;

    /**
     * Distance to station.
     *
     * @var \Rugaard\DMI\Support\Distance|null
     */
    protected ?Distance $distance = null;

    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        // Set stations unique ID.
        $this->setUuid($data['id']);

        // Set location of station.
        if (!empty($data['geometry']['coordinates'][0]) && !empty($data['geometry']['coordinates'][1])) {
            $this->setLocation(
                new Location($data['geometry']['type'], $data['geometry']['coordinates'])
            );
        }

        // Set stations properties.
        foreach ($data['properties'] as $key => $value) {
            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'stationId':
                    $this->setId($value);
                    break;
                case 'operationFrom':
                    $this->setOperatingFrom($value);
                    break;
                case 'operationTo':
                    $this->setOperatingTo($value);
                    break;
                case 'validFrom':
                    $this->setValidFrom($value);
                    break;
                case 'validTo':
                    $this->setValidTo($value);
                    break;
                case 'updated':
                    $this->setUpdatedAt($value);
                    break;
                case 'name':
                case 'owner':
                case 'type':
                case 'country':
                case 'status':
                    $this->{'set' . ucfirst($key)}($value);
                    break;
            }
        }
    }

    /**
     * Set station ID.
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get station ID.
     *
     * @return string|null
     */
    public function getId():? string
    {
        return $this->id;
    }

    /**
     * Set station UUID.
     *
     * @param string $uuid
     * @return $this
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * Get station UUID.
     *
     * @return string|null
     */
    public function getUuid():? string
    {
        return $this->uuid;
    }

    /**
     * Set country where station is located.
     *
     * @param string $country
     * @return $this
     */
    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country where station is located.
     *
     * @return string|null
     */
    public function getCountry():? string
    {
        return $this->country;
    }

    /**
     * Set station name.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get station name.
     *
     * @return string|null
     */
    public function getName():? string
    {
        return $this->name;
    }

    /**
     * Set location of station.
     *
     * @param \Rugaard\DMI\Support\Location $location
     * @return $this
     */
    public function setLocation(Location $location): self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get location of station.
     *
     * @return \Rugaard\DMI\Support\Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * Set station owner.
     *
     * @param string $owner
     * @return $this
     */
    public function setOwner(string $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    /**
     * Get station owner.
     *
     * @return string|null
     */
    public function getOwner():? string
    {
        return $this->owner;
    }

    /**
     * Set station status.
     *
     * @param string $status
     * @return $this
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get station status.
     *
     * @return string|null
     */
    public function getStatus():? string
    {
        return $this->status;
    }

    /**
     * Set station type.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get station type.
     *
     * @return string|null
     */
    public function getType():? string
    {
        return $this->type;
    }

    /**
     * Set timestamp of last station update.
     *
     * @param string $timestamp
     * @return $this
     */
    public function setUpdatedAt(string $timestamp): self
    {
        $this->updatedAt = date_create($timestamp);
        return $this;
    }

    /**
     * Get timestamp of last station update.
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt():? DateTime
    {
        return $this->updatedAt;
    }

    /**
     * Set timestamp of when station is/was operating from.
     *
     * @param string $from
     * @return $this
     */
    public function setOperatingFrom(string $from): self
    {
        if (!($this->operating instanceof DateTimePeriod)) {
            $this->operating = new DateTimePeriod;
        }

        $this->operating->setFrom($from);
        return $this;
    }

    /**
     * Get timestamp of when station is/was operating from.
     *
     * @return \DateTime|null
     */
    public function getOperatingFrom():? DateTime
    {
        return $this->operating->from();
    }

    /**
     * Set timestamp of when station is/was operating to.
     *
     * @param string $to
     * @return $this
     */
    public function setOperatingTo(string $to): self
    {
        if (!($this->operating instanceof DateTimePeriod)) {
            $this->operating = new DateTimePeriod;
        }

        $this->operating->setTo($to);
        return $this;
    }

    /**
     * Get timestamp of when station is/was operating to.
     *
     * @return \DateTime|null
     */
    public function getOperatingTo():? DateTime
    {
        return $this->operating->to();
    }

    /**
     * Set period where station are operational.
     *
     * @param string|null $from
     * @param string|null $to
     * @return $this
     */
    public function setOperating(?string $from = null, ?string $to = null): self
    {
        $this->operating = new DateTimePeriod($from, $to);
        return $this;
    }

    /**
     * Get period where station are operational.
     *
     * @return \Rugaard\DMI\Support\DateTimePeriod|null
     */
    public function getOperating():? DateTimePeriod
    {
        return $this->operating;
    }

    /**
     * Set timestamp of when station measurements are valid from.
     *
     * @param string $from
     * @return $this
     */
    public function setValidFrom(string $from): self
    {
        if (!($this->valid instanceof DateTimePeriod)) {
            $this->valid = new DateTimePeriod;
        }

        $this->valid->setFrom($from);
        return $this;
    }

    /**
     * Get timestamp of when station measurements are valid from.
     *
     * @return \DateTime|null
     */
    public function getValidFrom():? DateTime
    {
        return $this->valid->from();
    }

    /**
     * Set timestamp of when station measurements are valid to.
     *
     * @param string $to
     * @return $this
     */
    public function setValidTo(string $to): self
    {
        if (!($this->valid instanceof DateTimePeriod)) {
            $this->valid = new DateTimePeriod;
        }

        $this->valid->setTo($to);
        return $this;
    }

    /**
     * Get timestamp of when station measurements are valid to.
     *
     * @return \DateTime|null
     */
    public function getValidTo():? DateTime
    {
        return $this->valid->to();
    }

    /**
     * Set period where station measurements are valid.
     *
     * @param string|null $from
     * @param string|null $to
     * @return $this
     */
    public function setValid(?string $from = null, ?string $to = null): self
    {
        $this->valid = new DateTimePeriod($from, $to);
        return $this;
    }

    /**
     * Get period where station measurements are valid.
     *
     * @return \Rugaard\DMI\Support\DateTimePeriod|null
     */
    public function getValid():? DateTimePeriod
    {
        return $this->valid;
    }

    /**
     * Set distance to station.
     *
     * @param \Rugaard\DMI\Support\Distance $distance
     * @return $this
     */
    public function setDistance(Distance $distance): self
    {
        $this->distance = $distance;
        return $this;
    }

    /**
     * Get distance to station.
     *
     * @return \Rugaard\DMI\Support\Distance|null
     */
    public function getDistance():? Distance
    {
        return $this->distance;
    }

    /**
     * Calculate distance to station from coordinates (in meters).
     *
     * @param float $latitude
     * @param float $longitude
     * @return $this
     */
    public function calculateDistance(float $latitude, float $longitude): self
    {
        // Calculate distance to station.
        static $radius = M_PI / 180.0;
        $distance = (12742 * 1000) * asin(sqrt(0.5 -
            cos(($this->location->getCoordinates()->latitude() - $latitude) * $radius) / 2.0 +
            cos($latitude * $radius) *
            cos($this->location->getCoordinates()->longitude() * $radius) *
            (1.0 - cos(($this->location->getCoordinates()->longitude() - $longitude) * $radius)) / 2.0
        ));

        // Set station's distance.
        $this->setDistance(
            new Distance($distance)
        );

        return $this;
    }
}
