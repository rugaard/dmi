<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Meteorological\Snow;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Enums\Meteorological\SnowCover;
use Rugaard\DMI\Units\Quarter;

/**
 * Class Cover.
 */
class Cover extends Observation
{
    /**
     * Value of observation.
     *
     * @var SnowCover
     */
    public SnowCover $value;

    /**
     * Unit of value.
     *
     * @var Quarter
     */
    public Quarter $unit;

    /**
     * Cover constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Quarter;
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
            0 => SnowCover::None,
            1 => SnowCover::OneQuarter,
            2 => SnowCover::TwoQuarters,
            3 => SnowCover::ThreeQuarters,
            4 => SnowCover::FourQuarters,
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
     * Get value as a percentage.
     *
     * @return string
     */
    public function getValueAsPercentage(): string
    {
        return $this->value->percentage();
    }
}
