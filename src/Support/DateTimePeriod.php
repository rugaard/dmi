<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support;

use DateTime;
use DateTimeInterface;
use DateTimeZone;

use function in_array;
use function is_string;

/**
 * Class DateTimePeriod.
 *
 * @package Rugaard\DMI\Support
 */
class DateTimePeriod
{
    /**
     * Get "from" date.
     *
     * @var \DateTime
     */
    protected DateTime $from;

    /**
     * Get "to" date.
     *
     * @var \DateTime|null
     */
    protected ?DateTime $to;

    /**
     * Timezone of dates.
     *
     * @var \DateTimeZone
     */
    protected DateTimeZone $timezone;

    /**
     * DateTimePeriod constructor.
     *
     * @param \DateTime|string $fromDate
     * @param \DateTime|string|null $toDate
     * @param \DateTimeZone|string $timezone
     * @param string $dateFormat
     */
    public function __construct(DateTime|string $fromDate, DateTime|string $toDate = null, DateTimeZone|string $timezone = 'Z', string $dateFormat = DateTimeInterface::RFC3339)
    {
        // Set timezone.
        $this->setTimezone($timezone);

        // Set "from" date.
        $this->setFromDate($fromDate, $dateFormat);

        // If available, set "to" date.
        if (!empty($toDate)) {
            $this->setToDate($toDate, $dateFormat);
        }
    }

    /**
     * Set "from" date.
     *
     * @param \DateTime|string $fromDate
     * @param string $dateFormat
     * @return $this
     */
    public function setFromDate(DateTime|string $fromDate, string $dateFormat = DateTimeInterface::RFC3339): self
    {
        $this->from = is_string($fromDate) ? DateTime::createFromFormat($dateFormat, $fromDate, $this->getTimezone()) : $fromDate;
        return $this;
    }

    /**
     * Get "from" date.
     *
     * @return \DateTime
     */
    public function getFromDate(): DateTime
    {
        return $this->from;
    }

    /**
     * Set "to" date.
     *
     * @param \DateTime|string $toDate
     * @param string $dateFormat
     * @return $this
     */
    public function setToDate(DateTime|string $toDate, string $dateFormat = DateTimeInterface::RFC3339): self
    {
        $this->to =  is_string($toDate) ? DateTime::createFromFormat($dateFormat, $toDate, $this->getTimezone()) : $toDate;
        return $this;
    }

    /**
     * Get "to" date.
     *
     * @return \DateTime
     */
    public function getToDate(): DateTime
    {
        return $this->to;
    }

    /**
     * Set timezone of dates.
     *
     * @param \DateTimeZone|string|null $timezone
     * @return $this
     */
    public function setTimezone(DateTimeZone|string $timezone = null): self
    {
        if ($timezone instanceof DateTimeZone) {
            $this->timezone = $timezone;
            return $this;
        }

        $this->timezone = in_array($timezone, DateTimeZone::listIdentifiers(), true) ? new DateTimeZone($timezone) : new DateTimeZone('Z');
        return $this;
    }

    /**
     * Get timezone.
     *
     * @return \DateTimeZone
     */
    public function getTimezone(): DateTimeZone
    {
        return $this->timezone;
    }
}
