<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use DateTime;
use DateTimeZone;
use Tightenco\Collect\Support\Collection;

/**
 * Class SeaStation
 *
 * @package Rugaard\DMI\DTO
 */
class SeaStation extends AbstractDTO
{
    /**
     * Station ID.
     *
     * @var int|null
     */
    protected $id;

    /**
     * Station name.
     *
     * @var int|null
     */
    protected $name;

    /**
     * Station location.
     *
     * @var int|null
     */
    protected $location;

    /**
     * Station latitude coordinate.
     *
     * @var int|null
     */
    protected $latitude;

    /**
     * Station longitude coordinate.
     *
     * @var int|null
     */
    protected $longitude;

    /**
     * Country where station is located.
     *
     * @var int|null
     */
    protected $country;

    /**
     * Station "year 20 event" value (in centimeters).
     *
     * @var int|null
     */
    protected $year20event;

    /**
     * Whether or not station measures sea level.
     *
     * @var int|null
     */
    protected $levelMeasurement = false;

    /**
     * Whether or not station measures sea temperature.
     *
     * @var int|null
     */
    protected $temperatureMeasurement = false;

    /**
     * Whether or not station measures salinity.
     *
     * @var int|null
     */
    protected $salinityMeasurement = false;

    /**
     * Whether or not station measures sea current.
     *
     * @var int|null
     */
    protected $currentMeasurement = false;

    /**
     * Whether or not station measures waves.
     *
     * @var int|null
     */
    protected $waveMeasurement = false;

    /**
     * Whether or not station measures tide.
     *
     * @var int|null
     */
    protected $tideMeasurement = false;

    /**
     * Meta data about station.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $meta;

    /**
     * Collection of observations from station.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $observations;

    /**
     * Collection of forecast observations from station.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $forecast;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setId((int) $data['id'])
             ->setName($data['name'])
             ->setLocation($data['location'])
             ->setLatitude((float) $data['latitude'])
             ->setLongitude((float) $data['longitude'])
             ->setCountry($data['country'])
             ->setYear20Event($data['year20event'] ?? null)
             ->setLevelMeasurement((bool) $data['hassealevel'])
             ->setTemperatureMeasurement((bool) $data['hasseatemp'])
             ->setSalinityMeasurement((bool) $data['hassalinity'])
             ->setCurrentMeasurement((bool) $data['hascurrent'])
             ->setWaveMeasurement((bool) $data['haswave'])
             ->setTideMeasurement((bool) $data['hastide'])
             ->setMeta($data['_id'] ?? []);
    }

    /**
     * Set station ID.
     *
     * @param  int $id
     * @return $this
     */
    public function setId(int $id) : self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get station ID.
     *
     * @return int|null
     */
    public function getId() :? int
    {
        return $this->id;
    }

    /**
     * Set station name.
     *
     * @param  string $name
     * @return $this
     */
    public function setName(string $name) : self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get station name.
     *
     * @return string|null
     */
    public function getName() :? string
    {
        return $this->name;
    }

    /**
     * Set station location.
     *
     * @param  string $location
     * @return $this
     */
    public function setLocation(string $location) : self
    {
        $this->location = $location;
        return $this;
    }

    /**
     * Get station location.
     *
     * @return string|null
     */
    public function getLocation() :? string
    {
        return $this->location;
    }

    /**
     * Set station latitude coordinate.
     *
     * @param  float $latitude
     * @return $this
     */
    public function setLatitude(float $latitude) : self
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get station latitude coordinate.
     *
     * @return float|null
     */
    public function getLatitude() :? float
    {
        return $this->latitude;
    }

    /**
     * Set station longitude coordinate.
     *
     * @param  float $longitude
     * @return $this
     */
    public function setLongitude(float $longitude) : self
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get station longitude coordinate.
     *
     * @return float|null
     */
    public function getLongitude() :? float
    {
        return $this->longitude;
    }

    /**
     * Set country where station is located.
     *
     * @param  string $country
     * @return $this
     */
    public function setCountry(string $country) : self
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country where station is located.
     *
     * @return string|null
     */
    public function getCountry() :? string
    {
        return $this->country;
    }

    /**
     * Set station's "year 20 event" value.
     *
     * @param  int|null $value
     * @return $this
     */
    public function setYear20Event(?int $value) : self
    {
        $this->year20event = $value;
        return $this;
    }

    /**
     * Get station's "year 20 event" value.
     *
     * @return int|null
     */
    public function getYear20Event() :? int
    {
        return $this->year20event;
    }

    /**
     * Set whether or not station measures sea level.
     *
     * @param  bool $state
     * @return $this
     */
    public function setLevelMeasurement(bool $state) : self
    {
        $this->levelMeasurement = $state;
        return $this;
    }

    /**
     * Get whether or not station measures sea level.
     *
     * @return bool|null
     */
    public function getLevelMeasurement() :? bool
    {
        return $this->levelMeasurement;
    }

    /**
     * Set whether or not station measures sea temperature.
     *
     * @param  bool $state
     * @return $this
     */
    public function setTemperatureMeasurement(bool $state) : self
    {
        $this->temperatureMeasurement = $state;
        return $this;
    }

    /**
     * Get whether or not station measures sea temperature.
     *
     * @return bool|null
     */
    public function getTemperatureMeasurement() :? bool
    {
        return $this->temperatureMeasurement;
    }

    /**
     * Set whether or not station measures salinity.
     *
     * @param  bool $state
     * @return $this
     */
    public function setSalinityMeasurement(bool $state) : self
    {
        $this->salinityMeasurement = $state;
        return $this;
    }

    /**
     * Get whether or not station measures salinity..
     *
     * @return bool|null
     */
    public function getSalinityMeasurement() :? bool
    {
        return $this->salinityMeasurement;
    }

    /**
     * Set whether or not station measures sea current.
     *
     * @param  bool $state
     * @return $this
     */
    public function setCurrentMeasurement(bool $state) : self
    {
        $this->currentMeasurement = $state;
        return $this;
    }

    /**
     * Get whether or not station measures sea current.
     *
     * @return bool|null
     */
    public function getCurrentMeasurement() :? bool
    {
        return $this->currentMeasurement;
    }

    /**
     * Set whether or not station measures waves.
     *
     * @param  bool $state
     * @return $this
     */
    public function setWaveMeasurement(bool $state) : self
    {
        $this->waveMeasurement = $state;
        return $this;
    }

    /**
     * Get whether or not station measures waves.
     *
     * @return bool|null
     */
    public function getWaveMeasurement() :? bool
    {
        return $this->waveMeasurement;
    }

    /**
     * Set whether or not station measures tide.
     *
     * @param  bool $state
     * @return $this
     */
    public function setTideMeasurement(bool $state) : self
    {
        $this->tideMeasurement = $state;
        return $this;
    }

    /**
     * Get whether or not station measures tide.
     *
     * @return bool|null
     */
    public function getTideMeasurement() :? bool
    {
        return $this->tideMeasurement;
    }

    /**
     * Set meta data about station.
     *
     * @param  array $meta
     * @return $this
     */
    public function setMeta(array $meta) : self
    {
        $this->meta = Collection::make([
            'counter' => $meta['counter'] ?? null,
            'machineIdentifier' => $meta['machineIdentifier'] ?? null,
            'processIdentifier' => $meta['processIdentifier'] ?? null,
            'timestamp' =>  $meta['timestamp'] ? DateTime::createFromFormat('U', (string) $meta['timestamp'])->setTimezone(new DateTimeZone('Europe/Copenhagen')) : null,
        ]);
        return $this;
    }

    /**
     * Get meta data about station.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getMeta() :? Collection
    {
        return $this->meta;
    }

    /**
     * Set observations from station.
     *
     * @param  \Tightenco\Collect\Support\Collection|null $observations
     * @return $this
     */
    public function setObservations(?Collection $observations) : self
    {
        $this->observations = $observations;
        return $this;
    }

    /**
     * Get observations from station.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getObservations() :? Collection
    {
        return $this->observations;
    }

    /**
     * Set forecast observations from station.
     *
     * @param  \Tightenco\Collect\Support\Collection|null $forecast
     * @return $this
     */
    public function setForecast(?Collection $forecast) : self
    {
        $this->forecast = $forecast;
        return $this;
    }

    /**
     * Get observations from station.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getForecast() :? Collection
    {
        return $this->forecast;
    }
}