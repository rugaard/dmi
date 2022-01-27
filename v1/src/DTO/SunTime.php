<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\DTO;

use DateTime;
use DateTimeZone;

/**
 * Class SunTime
 *
 * @package Rugaard\DMI\Old\DTO
 */
class SunTime extends AbstractDTO
{
    /**
     * Sunrise timestamp.
     *
     * @var \DateTime|null
     */
    protected $sunrise;

    /**
     * Sunset timestamp.
     *
     * @var \DateTime|null
     */
    protected $sunset;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setSunrise($data['sunUp'])
             ->setSunset($data['sunDown']);
    }

    /**
     * Set sunrise timestamp.
     *
     * @param  string $sunriseTimestamp
     * @return $this
     */
    public function setSunrise(string $sunriseTimestamp) : self
    {
        $this->sunrise = DateTime::createFromFormat('Y-m-d H:i', $sunriseTimestamp, new DateTimeZone('Europe/Copenhagen'));
        return $this;
    }

    /**
     * Get sunrise timestamp.
     *
     * @return \DateTime|null
     */
    public function getSunrise() :? DateTime
    {
        return $this->sunrise;
    }

    /**
     * Set sunset timestamp.
     *
     * @param  string $sunsetTimestamp
     * @return $this
     */
    public function setSunset(string $sunsetTimestamp) : self
    {
        $this->sunset = DateTime::createFromFormat('Y-m-d H:i', $sunsetTimestamp, new DateTimeZone('Europe/Copenhagen'));
        return $this;
    }

    /**
     * Get sunset timestamp.
     *
     * @return \DateTime|null
     */
    public function getSunset() :? DateTime
    {
        return $this->sunset;
    }
}
