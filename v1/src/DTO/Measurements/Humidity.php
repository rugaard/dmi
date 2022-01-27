<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\DTO\Measurements;

use Rugaard\DMI\Old\Contracts\Unit;
use Rugaard\DMI\Old\DTO\AbstractDTO;
use Rugaard\DMI\Old\Units\Percentage;

/**
 * Class Humidity.
 *
 * @package Rugaard\DMI\Old\DTO\Measurements
 */
class Humidity extends AbstractDTO
{
    /**
     * Humidity value.
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
     * Humidity constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Set default unit.
        $this->setUnit(new Percentage);

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
        $this->setValue($data['humidity'] ?? null);
    }

    /**
     * Set humidity value.
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
     * Get humidity value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set humidity unit.
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
     * Get humidity unit.
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
        return round($this->getValue()) . $this->getUnit();
    }
}
