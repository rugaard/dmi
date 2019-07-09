<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements\Wind;

use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;

/**
 * Class Speed.
 *
 * @package Rugaard\DMI\DTO\Measurements\Wind
 */
class Speed extends AbstractDTO
{
    /**
     * Wind speed value.
     *
     * @var float
     */
    protected $value = 0.0;

    /**
     * Lowest predicted wind speed (uncertain).
     *
     * @var float
     */
    protected $lowestValue = 0.0;

    /**
     * Highest predicted wind speed (uncertain).
     *
     * @var float
     */
    protected $highestValue = 0.0;

    /**
     * Unit type.
     *
     * @var \Rugaard\DMI\Contracts\Unit|null
     */
    protected $unit;

    /**
     * Speed constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Set default unit.
        $this->setUnit(new MetersPerSecond);

        parent::__construct($data);
    }

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->setValue((float) $data['windSpeed'])
             ->setLowestValue( (float) $data['windspeed10'])
             ->setHighestValue((float) $data['windspeed90']);
    }

    /**
     * Set wind speed value.
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
     * Get wind speed value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set lowest predicted wind speed (uncertain).
     *
     * @param  float|null $value
     * @return $this
     */
    public function setLowestValue(?float $value) : self
    {
        $this->lowestValue = $value !== null ? (float) $value : 0.0;
        return $this;
    }

    /**
     * Get lowest predicted wind speed (uncertain).
     *
     * @return float|null
     */
    public function getLowestValue() :? float
    {
        return $this->lowestValue;
    }

    /**
     * Set highest predicted wind speed (uncertain).
     *
     * @param  float|null $value
     * @return $this
     */
    public function setHighestValue(?float $value) : self
    {
        $this->highestValue = $value !== null ? (float) $value : 0.0;
        return $this;
    }

    /**
     * Get highest predicted wind speed (uncertain).
     *
     * @return float|null
     */
    public function getHighestValue() :? float
    {
        return $this->highestValue;
    }

    /**
     * Set wind speed unit.
     *
     * @param  \Rugaard\DMI\Contracts\Unit $unit
     * @return $this
     */
    public function setUnit(Unit $unit) : self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Get wind speed unit.
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
        return number_format(round($this->getValue(), 1), 1, '.', '') . ' ' . $this->getUnit();
    }
}