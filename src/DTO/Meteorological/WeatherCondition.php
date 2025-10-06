<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological;

use Rugaard\DMI\Abstracts\Observations\Meteorological as MeteorologicalObservation;
use Rugaard\DMI\Enums\Meteorological\WeatherCondition as WeatherConditionEnum;

/**
 * Class WeatherCondition.
 */
class WeatherCondition extends MeteorologicalObservation
{
    /**
     * Value of observation.
     *
     * @var WeatherConditionEnum
     */
    public WeatherConditionEnum $value;

    /**
     * Set observation value.
     *
     * @param float $value
     * @return $this
     */
    public function setValue(float $value): self
    {
        $this->value = WeatherConditionEnum::from(value: (int) $value);
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
}
