<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts\Observations;

use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Support\Attributes\CreatedTimestamp as HasCreatedTimestamp;
use Rugaard\DMI\Support\Attributes\ObservedTimestamp as HasObservedTimestamp;

/**
 * Class Lightning.
 */
abstract class Lightning extends Observation
{
    use HasCreatedTimestamp, HasObservedTimestamp;

    /**
     * Amount of lightning strokes.
     *
     * @var int
     */
    public int $strokes;

    /**
     * Measured amperage.
     *
     * @var float
     */
    public float $amperage;

    /**
     * Set amount of lightning strokes.
     *
     * @param float $value
     * @return $this
     */
    public function setStrokes(float $value): self
    {
        $this->strokes = (int) $value;
        return $this;
    }

    /**
     * Set measured amperage.
     *
     * @param float $value
     * @return $this
     */
    public function setAmp(float $value): self
    {
        $this->amperage = $value;
        return $this;
    }
}
