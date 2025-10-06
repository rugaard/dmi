<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts\Observations;

use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Enums\Meteorological\Parameter as MeteorologicalType;
use Rugaard\DMI\Support\Attributes\ObservedTimestamp as HasObservedTimestamp;

/**
 * Class Meteorological.
 */
abstract class Meteorological extends Observation
{
    use HasObservedTimestamp;

    /**
     * ID of observation station.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Observation parameter.
     *
     * @var MeteorologicalType
     */
    public MeteorologicalType $parameter;

    /**
     * Description of observation.
     *
     * @var string
     */
    public string $description;

    /**
     * Set parameter and description from parameter ID.
     *
     * @param string $parameterId
     * @return $this
     */
    protected function setParameterId(string $parameterId): self
    {
        // Get parameter from parameter ID.
        $parameter = $this->parameter = MeteorologicalType::from(value: $parameterId);

        // Set observation description from parameter.
        $this->description = $parameter->description();

        return $this;
    }
}
