<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Archive;

use Rugaard\DMI\DTO\AbstractDTO;

use DateTime;
use DateTimeZone;

/**
 * Class Value.
 *
 * @package Rugaard\DMI\DTO\Archive
 */
class Value extends AbstractDTO
{
    /**
     * Value.
     *
     * @var float|null
     */
    protected $value;

    /**
     * Timestamp of value.
     *
     * @var \DateTime|null
     */
    protected $timestamp;

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        $this->setValue($data['value'])
             ->setTimestamp($data['dateLocalString'], $data['timezone']);
    }

    /**
     * Set value.
     *
     * @param  float|null $value
     * @return $this
     */
    public function setValue(?float $value) : self
    {
        $this->value = (float) $value;
        return $this;
    }

    /**
     * Get value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set timestamp of value.
     *
     * @param  string      $timestamp
     * @param  string|null $timezone
     * @return $this
     */
    public function setTimestamp(string $timestamp, ?string $timezone = null) : self
    {
        // If no timezone is provided,
        // we'll use "Europe/Copenhagen" as fallback.
        $timezone = new DateTimeZone($timezone ?? 'Europe/Copenhagen');

        $this->timestamp = DateTime::createFromFormat('d-m-Y H:i', $timestamp, $timezone);
        return $this;
    }

    /**
     * Get timestamp of value.
     *
     * @return \DateTime|null
     */
    public function getTimestamp() :? DateTime
    {
        return $this->timestamp;
    }
}