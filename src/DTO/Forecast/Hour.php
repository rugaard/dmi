<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Forecast;

use DateTime;
use DateTimeZone;
use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Measurements\Humidity;
use Rugaard\DMI\DTO\Measurements\Precipitation;
use Rugaard\DMI\DTO\Measurements\Pressure;
use Rugaard\DMI\DTO\Measurements\Temperature;
use Rugaard\DMI\DTO\Measurements\Visibility;
use Rugaard\DMI\DTO\Measurements\Wind;
use Rugaard\DMI\Support\Traits\Icon;
use Tightenco\Collect\Support\Collection;

/**
 * Class Hour.
 *
 * @package Rugaard\DMI\DTO\Forecast
 */
class Hour extends AbstractDTO
{
    use Icon;

    /**
     * Temperature.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Temperature|null
     */
    protected $temperature;

    /**
     * Wind.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Wind|null
     */
    protected $wind;

    /**
     * Humidity.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Humidity|null
     */
    protected $humidity;

    /**
     * Pressure.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Pressure|null
     */
    protected $pressure;

    /**
     * Precipitation.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Precipitation|null
     */
    protected $precipitation;

    /**
     * Visibility.
     *
     * @var \Rugaard\DMI\DTO\Measurements\Visibility|null
     */
    protected $visibility;

    /**
     * Timestamp.
     *
     * @var \DateTime|null
     */
    protected $timestamp;

    /**
     * Warnings.
     *
     * @var \Tightenco\Collect\Support\Collection|null
     */
    protected $warnings;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data): void
    {
        // Use timezone, if available.
        // Otherwise use "Europe/Copenhagen" as fallback.
        $timezone = new DateTimeZone($data['timezone'] ?? 'Europe/Copenhagen');

        $this->setIconById($data['symbol'])
             ->setTemperature(new Temperature($data))
             ->setWind(new Wind($data))
             ->setHumidity(new Humidity($data))
             ->setPressure(new Pressure($data))
             ->setPrecipitation(new Precipitation($data))
             ->setVisibility(new Visibility($data))
             ->setTimestamp($data['time'], $timezone);
    }

    /**
     * Set timestamp.
     *
     * @param  string             $timestamp
     * @param  \DateTimeZone|null $timezone
     * @return $this
     */
    public function setTimestamp(string $timestamp, ?DateTimeZone $timezone = null) : self
    {
        $this->timestamp = DateTime::createFromFormat('YmdHis', $timestamp, $timezone);
        return $this;
    }

    /**
     * Get timestamp.
     *
     * @return \DateTime|null
     */
    public function getTimestamp() :? DateTime
    {
        return $this->timestamp;
    }

    /**
     * Set temperature.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Temperature $temperature
     * @return $this
     */
    public function setTemperature(Temperature $temperature) : self
    {
        $this->temperature = $temperature;
        return $this;
    }

    /**
     * Get temperature.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Temperature|null
     */
    public function getTemperature() :? Temperature
    {
        return $this->temperature;
    }

    /**
     * Set wind.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Wind $wind
     * @return $this
     */
    public function setWind(Wind $wind) : self
    {
        $this->wind = $wind;
        return $this;
    }

    /**
     * Get wind.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Wind|null
     */
    public function getWind() :? Wind
    {
        return $this->wind;
    }

    /**
     * Set humidity.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Humidity $humidity
     * @return $this
     */
    public function setHumidity(Humidity $humidity) : self
    {
        $this->humidity = $humidity;
        return $this;
    }

    /**
     * Get humidity.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Humidity|null
     */
    public function getHumidity() :? Humidity
    {
        return $this->humidity;
    }

    /**
     * Set humidity.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Pressure $pressure
     * @return $this
     */
    public function setPressure(Pressure $pressure) : self
    {
        $this->pressure = $pressure;
        return $this;
    }

    /**
     * Get humidity.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Pressure|null
     */
    public function getPressure() :? Pressure
    {
        return $this->pressure;
    }

    /**
     * Set precipitation.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Precipitation $precipitation
     * @return $this
     */
    public function setPrecipitation(Precipitation $precipitation) : self
    {
        $this->precipitation = $precipitation;
        return $this;
    }

    /**
     * Get precipitation.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Precipitation|null
     */
    public function getPrecipitation() :? Precipitation
    {
        return $this->precipitation;
    }

    /**
     * Set visibility.
     *
     * @param  \Rugaard\DMI\DTO\Measurements\Visibility $visibility
     * @return $this
     */
    public function setVisibility(Visibility $visibility) : self
    {
        $this->visibility = $visibility;
        return $this;
    }

    /**
     * Get visibility.
     *
     * @return \Rugaard\DMI\DTO\Measurements\Pressure|null
     */
    public function getVisibility() :? Visibility
    {
        return $this->visibility;
    }

    /**
     * Set warnings.
     *
     * @param  \Tightenco\Collect\Support\Collection|null $warnings
     * @return $this
     */
    public function setWarnings(?Collection $warnings) : self
    {
        $this->warnings = $warnings;
        return $this;
    }

    /**
     * Get warnings.
     *
     * @return \Tightenco\Collect\Support\Collection|null
     */
    public function getWarnings() :? Collection
    {
        return $this->warnings;
    }
}