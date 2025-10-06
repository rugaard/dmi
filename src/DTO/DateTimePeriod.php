<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use DateTime;
use DateTimeInterface;
use DateTimeZone;
use Rugaard\DMI\Abstracts\DTO;

use function in_array;
use function is_string;

/**
 * Class DateTimePeriod.
 */
class DateTimePeriod extends DTO
{
    /**
     * Get "from" date.
     *
     * @var DateTime
     */
    public DateTime $from;

    /**
     * Get "to" date.
     *
     * @var DateTime|null
     */
    public ?DateTime $to;

    /**
     * Timezone of dates.
     *
     * @var DateTimeZone
     */
    public DateTimeZone $timezone;

    /**
     * DateTimePeriod constructor.
     *
     * @param DateTime|string $fromDate
     * @param DateTime|string|null $toDate
     * @param DateTimeZone|string $timezone
     */
    public function __construct(DateTime|string $fromDate, DateTime|string|null $toDate = null, DateTimeZone|string $timezone = 'UTC')
    {
        parent::__construct(data: [
            'timezone' => $timezone,
            'from' => $fromDate,
            'to' => $toDate
        ]);
    }

    /**
     * Set "from" date.
     *
     * @param DateTime|string $fromDate
     * @return $this
     */
    public function setFrom(DateTime|string $fromDate): self
    {
        $this->from = is_string($fromDate) ? DateTime::createFromFormat(format: DateTimeInterface::RFC3339, datetime: $fromDate, timezone: $this->timezone) : $fromDate;
        return $this;
    }

    /**
     * Set "to" date.
     *
     * @param DateTime|string|null $toDate
     * @return $this
     */
    public function setTo(DateTime|string|null $toDate): self
    {
        $this->to = is_string(value: $toDate) ? DateTime::createFromFormat(format: DateTimeInterface::RFC3339, datetime: $toDate, timezone: $this->timezone) : $toDate;
        return $this;
    }

    /**
     * Set timezone of dates.
     *
     * @param DateTimeZone|string|null $timezone
     * @return $this
     */
    public function setTimezone(DateTimeZone|string|null $timezone = null): self
    {
        if ($timezone instanceof DateTimeZone) {
            $this->timezone = $timezone;
            return $this;
        }

        $this->timezone = $timezone !== null && in_array(needle:$timezone, haystack: DateTimeZone::listIdentifiers(), strict:true)
            ? new DateTimeZone(timezone: $timezone)
            : new DateTimeZone(timezone: 'UTC');

        return $this;
    }
}
