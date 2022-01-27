<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\DTO\Measurements;

use Rugaard\DMI\Old\Contracts\Unit;
use Rugaard\DMI\Old\DTO\AbstractDTO;
use Rugaard\DMI\Old\Units\Length\Meter;

/**
 * Class Visibility.
 *
 * @package Rugaard\DMI\Old\DTO\Measurements
 */
class Visibility extends AbstractDTO
{
    /**
     * Visibility value.
     *
     * @var float|null
     */
    protected $value;

    /**
     * Unit type.
     *
     * @var \Rugaard\DMI\Old\Contracts\Unit|null
     */
    protected $unit;

    /**
     * Visibility constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Set default unit.
        $this->setUnit(new Meter);

        parent::__construct($data);
    }

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->setValue($data['visibility'] ?? null);
    }

    /**
     * Set visibility value in kilometers.
     *
     * @param  float|null $value
     * @return $this
     */
    public function setValue(?float $value) : self
    {
        $this->value = $value !== null ? (float) $value : null;
        return $this;
    }

    /**
     * Get visibility value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set visibility unit.
     *
     * @param  \Rugaard\DMI\Old\Contracts\Unit $unit
     * @return $this
     */
    public function setUnit(Unit $unit) : self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Get visibility unit.
     *
     * @return \Rugaard\DMI\Old\Contracts\Unit|null
     */
    public function getUnit() :? Unit
    {
        return $this->unit;
    }

    /**
     * __toString().
     *
     * @return string
     */
    public function __toString() : string
    {
        return floor($this->getValue()) . ' ' . $this->getUnit();
    }
}
