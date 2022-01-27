<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\DTO\Forecast;

use DateTime;
use DateTimeZone;
use Rugaard\OldDMI\DTO\AbstractDTO;
use Rugaard\OldDMI\DTO\Measurements\Humidity;
use Rugaard\OldDMI\DTO\Measurements\Precipitation;
use Rugaard\OldDMI\DTO\Measurements\Pressure;
use Rugaard\OldDMI\DTO\Measurements\Temperature;
use Rugaard\OldDMI\DTO\Measurements\Visibility;
use Rugaard\OldDMI\DTO\Measurements\Wind;
use Rugaard\OldDMI\Support\Traits\Icon;
use Tightenco\Collect\Support\Collection;

/**
 * Class Day.
 *
 * @package Rugaard\OldDMI\DTO\Forecast
 */
class Day extends AbstractDTO
{
    use Icon;

    /**
     * Temperature.
     *
     * @var \Rugaard\OldDMI\DTO\Measurements\Temperature|null
     */
    protected $temperature;

    /**
     * Wind.
     *
     * @var \Rugaard\OldDMI\DTO\Measurements\Wind|null
     */
    protected $wind;

    /**
     * Humidity.
     *
     * @var \Rugaard\OldDMI\DTO\Measurements\Humidity|null
     */
    protected $humidity;

    /**
     * Pressure.
     *
     * @var \Rugaard\OldDMI\DTO\Measurements\Pressure|null
     */
    protected $pressure;

    /**
     * Precipitation.
     *
     * @var \Rugaard\OldDMI\DTO\Measurements\Precipitation|null
     */
    protected $precipitation;

    /**
     * Visibility.
     *
     * @var \Rugaard\OldDMI\DTO\Measurements\Visibility|null
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

        $this->setHumidity(new Humidity($data))
             ->setPressure(new Pressure($data))
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
    public function setTimestamp(string $timestamp, $timezone = null) : self
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
     * @param  \Rugaard\OldDMI\DTO\Measurements\Temperature $temperature
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
     * @return \Rugaard\OldDMI\DTO\Measurements\Temperature|null
     */
    public function getTemperature() :? Temperature
    {
        return $this->temperature;
    }

    /**
     * Set precipitation.
     *
     * @param  \Rugaard\OldDMI\DTO\Measurements\Precipitation $precipitation
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
     * @return \Rugaard\OldDMI\DTO\Measurements\Precipitation|null
     */
    public function getPrecipitation() :? Precipitation
    {
        return $this->precipitation;
    }

    /**
     * Set wind.
     *
     * @param  \Rugaard\OldDMI\DTO\Measurements\Wind $wind
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
     * @return \Rugaard\OldDMI\DTO\Measurements\Wind|null
     */
    public function getWind() :? Wind
    {
        return $this->wind;
    }

    /**
     * Set pressure.
     *
     * @param  \Rugaard\OldDMI\DTO\Measurements\Pressure $pressure
     * @return $this
     */
    public function setPressure(Pressure $pressure) : self
    {
        $this->pressure = $pressure;
        return $this;
    }

    /**
     * Get pressure.
     *
     * @return \Rugaard\OldDMI\DTO\Measurements\Pressure|null
     */
    public function getPressure() :? Pressure
    {
        return $this->pressure;
    }

    /**
     * Set humidity.
     *
     * @param  \Rugaard\OldDMI\DTO\Measurements\Humidity $humidity
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
     * @return \Rugaard\OldDMI\DTO\Measurements\Humidity|null
     */
    public function getHumidity() :? Humidity
    {
        return $this->humidity;
    }

    /**
     * Set visibility.
     *
     * @param  \Rugaard\OldDMI\DTO\Measurements\Visibility $visibility
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
     * @return \Rugaard\OldDMI\DTO\Measurements\Visibility|null
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
