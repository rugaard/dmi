<?php
declare(strict_types=1);

namespace Rugaard\DMI\Attributes;

use Rugaard\DMI\Contracts\Unit;

/**
 * Trait HasUnit.
 *
 * @package Rugaard\DMI\Attributes
 */
trait HasUnit
{
    /**
     * Unit attribute.
     *
     * @var \Rugaard\DMI\Contracts\Unit
     */
    protected Unit $unit;

    /**
     * Set unit attribute.
     *
     * @param \Rugaard\DMI\Contracts\Unit $unit
     * @return $this
     */
    public function setUnit(Unit $unit): self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Get unit attribute.
     *
     * @return \Rugaard\DMI\Contracts\Unit
     */
    public function getUnit(): Unit
    {
        return $this->unit;
    }
}
