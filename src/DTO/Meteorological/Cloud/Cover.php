<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Cloud;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Meteorological as MeteorologicalObservation;
use Rugaard\DMI\Enums\Meteorological\CloudCover;
use Rugaard\DMI\Units\Okta;

/**
 * Class Cover.
 */
class Cover extends MeteorologicalObservation
{
    /**
     * Value of observation.
     *
     * @var CloudCover
     */
    public CloudCover $value;

    /**
     * Unit of value.
     *
     * @var Okta
     */
    public Okta $unit;

    /**
     * Cover constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Okta;
    }

    /**
     * Set observation value.
     *
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = match ((int) $value) {
            0 => CloudCover::Clear,
            10 => CloudCover::FewCloudsOrClear,
            25 => CloudCover::FewClouds,
            40 => CloudCover::ScatteredClouds,
            50 => CloudCover::PartlyCloudy,
            60 => CloudCover::BrokenClouds,
            75 => CloudCover::Cloudy,
            90 => CloudCover::VeryCloudy,
            100 => CloudCover::Overcast,
            112 => CloudCover::Obscured,
        };
        return $this;
    }

    /**
     * Get description of value.
     *
     * @return string
     */
    public function getValueDescription(): string
    {
        return $this->value->description();
    }

    /**
     * Get abbreviation of value.
     *
     * @return string
     */
    public function getValueAbbreviation(): string
    {
        return $this->value->abbreviation();
    }

    /**
     * Get value as a percentage range.
     *
     * @return string
     */
    public function getValueAsPercentage(): string
    {
        return $this->value->percentage();
    }
}
