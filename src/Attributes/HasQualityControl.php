<?php
declare(strict_types=1);

namespace Rugaard\DMI\Attributes;

use DateTime;
use Rugaard\DMI\Support\DateTimePeriod;

/**
 * Trait HasQualityControl.
 *
 * @package Rugaard\DMI\Attributes
 */
trait HasQualityControl
{
    /**
     * Number of values attribute.
     *
     * @var float|null
     */
    protected ?float $numberOfValues;

    /**
     * Timespan attribute.
     *
     * @var string|null
     */
    protected ?string $timespan;

    /**
     * Time period attribute.
     *
     * @var \Rugaard\DMI\Support\DateTimePeriod|null
     */
    protected ?DateTimePeriod $timePeriod;

    /**
     * Calculated timestamp attribute.
     *
     * @var \DateTime|null
     */
    protected ?DateTime $calculatedAt;

    /**
     * Validity attribute.
     *
     * @var bool
     */
    protected bool $isValid = false;

    /**
     * Manually verified attribute.
     *
     * @var bool
     */
    protected bool $isManuallyVerified = false;

    /**
     * Set number of values attribute.
     *
     * @param float $value
     * @return $this
     */
    public function setNumberOfValues(float $value): self
    {
        $this->numberOfValues = $value;
        return $this;
    }

    /**
     * Get number of values attribute.
     *
     * @return float|null
     */
    public function getNumberOfValues():? float
    {
        return $this->numberOfValues;
    }

    /**
     * Set timespan attribute.
     *
     * @param string $timespan
     * @return $this
     */
    public function setTimespan(string $timespan): self
    {
        $this->timespan = $timespan;
        return $this;
    }

    /**
     * Get timespan attribute.
     *
     * @return string|null
     */
    public function getTimespan():? string
    {
        return $this->timespan;
    }

    /**
     * Set time period attribute.
     *
     * @param string $from
     * @param string $to
     * @return $this
     */
    public function setTimePeriod(string $from, string $to): self
    {
        $this->timePeriod = new DateTimePeriod($from, $to);
        return $this;
    }

    /**
     * Get time period attribute.
     *
     * @return \Rugaard\DMI\Support\DateTimePeriod|null
     */
    public function getTimePeriod():? DateTimePeriod
    {
        return $this->timePeriod;
    }

    /**
     * Set calculation timestamp.
     *
     * @param string $timestamp
     * @return $this
     */
    public function setCalculatedAt(string $timestamp): self
    {
        $this->calculatedAt = date_create($timestamp);
        return $this;
    }

    /**
     * Get calculation timestamp.
     *
     * @return \DateTime|null
     */
    public function getCalculatedAt():? DateTime
    {
        return $this->calculatedAt;
    }

    /**
     * Set validity attribute.
     *
     * @param bool $value
     * @return $this
     */
    public function setValid(bool $value): self
    {
        $this->isValid = $value;
        return $this;
    }

    /**
     * Get validity attribute.
     *
     * @return bool
     */
    public function getValid(): bool
    {
        return $this->isValid;
    }

    /**
     * Set manually verified attribute.
     *
     * @param bool $value
     * @return $this
     */
    public function setManuallyVerified(bool $value): self
    {
        $this->isManuallyVerified = $value;
        return $this;
    }

    /**
     * Get manually verified attribute.
     *
     * @return bool
     */
    public function getManuallyVerified(): bool
    {
        return $this->isManuallyVerified;
    }
}
