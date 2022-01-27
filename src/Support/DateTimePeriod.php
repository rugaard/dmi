<?php
declare(strict_types=1);

namespace Rugaard\DMI\Support;

use DateTime;
use DateTimeInterface;

/**
 * Class DateTimePeriod.
 *
 * @package Rugaard\DMI\Support
 */
class DateTimePeriod
{
    /**
     * From DateTime object.
     *
     * @var \DateTime|null
     */
    protected ?DateTime $from = null;

    /**
     * To DateTime object.
     *
     * @var \DateTime|null
     */
    protected ?DateTime $to = null;

    /**
     * DateTimePeriod constructor.
     *
     * @param \DateTime|string|null $from
     * @param \DateTime|string|null $to
     */
    public function __construct(DateTime|string|null $from = null, DateTime|string|null $to = null)
    {
        if ($from !== null) {
            $this->setFrom($from);
        }

        if ($to !== null) {
            $this->setTo($to);
        }
    }

    /**
     * Set "from" DateTime object.
     *
     * @param \DateTime|string $from
     * @return $this
     */
    public function setFrom(DateTime|string $from): self
    {
        if (!($from instanceof DateTime)) {
            $from = date_create($from);
        }

        $this->from = $from;
        return $this;
    }

    /**
     * Get "from" DateTime object.
     *
     * @return \DateTime|null
     */
    public function from():? DateTime
    {
        return $this->from;
    }

    /**
     * Set "to" DateTime object.
     *
     * @param \DateTime|string $to
     * @return $this
     */
    public function setTo(DateTime|string $to): self
    {
        if (!($to instanceof DateTime)) {
            $to = date_create($to);
        }

        $this->to = $to;
        return $this;
    }

    /**
     * Get "to" DateTime object.
     *
     * @return \DateTime|null
     */
    public function to():? DateTime
    {
        return $this->to;
    }
}
