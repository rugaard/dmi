<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements;

use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Units\Pressure\Hectopascal;

/**
 * Class Pressure.
 *
 * @package Rugaard\DMI\DTO\Measurements
 */
class Pressure extends AbstractDTO
{
    /**
     * Pressure value.
     *
     * @var float
     */
    protected $value  = 0.0;

    /**
     * Unit type.
     *
     * @var \Rugaard\DMI\Contracts\Unit|null
     */
    protected $unit;

    /**
     * Pressure constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Set default unit.
        $this->setUnit(new Hectopascal);

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
        $this->setValue((float) $data['pressure']);
    }

    /**
     * Set pressure value.
     *
     * @param  float|null $value
     * @return $this
     */
    public function setValue(?float $value) : self
    {
        $this->value = $value !== null ? (float) $value : 0.0;
        return $this;
    }

    /**
     * Get pressure value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set pressure unit.
     *
     * @param  \Rugaard\DMI\Contracts\Unit $unit
     * @return self
     */
    public function setUnit(Unit $unit) : self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Get pressure unit.
     *
     * @return \Rugaard\DMI\Contracts\Unit|null
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
        return round($this->getValue()) . ' ' . $this->getUnit();
    }
}