<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\DTO\Measurements\Wind;

use Rugaard\DMI\Old\Contracts\Unit;
use Rugaard\DMI\Old\DTO\AbstractDTO;
use Rugaard\DMI\Old\Units\Speed\MetersPerSecond;

/**
 * Class Speed.
 *
 * @package Rugaard\DMI\Old\DTO\Measurements\Wind
 */
class Speed extends AbstractDTO
{
    /**
     * Wind speed value.
     *
     * @var float|null
     */
    protected $value;

    /**
     * Lowest predicted wind speed (uncertain).
     *
     * @var float|null
     */
    protected $lowestValue;

    /**
     * Highest predicted wind speed (uncertain).
     *
     * @var float|null
     */
    protected $highestValue;

    /**
     * Unit type.
     *
     * @var \Rugaard\DMI\Old\Contracts\Unit|null
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
        // If "temp50" is empty,
        // then we know EPS is not available.
        if (!empty($data['temp50'])) {
            $this->setValue($data['windspeed50'] ?? null)
                 ->setLowestValue($data['windspeed10'] ?? null)
                 ->setHighestValue($data['windspeed90'] ?? null);
        } else {
            $this->setValue($data['windSpeed'] ?? null);
        }
    }

    /**
     * Set wind speed value.
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
        $this->lowestValue = $value !== null ? (float) $value : null;
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
        $this->highestValue = $value !== null ? (float) $value : null;
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
     * @param  \Rugaard\DMI\Old\Contracts\Unit $unit
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
        return number_format(round($this->getValue(), 1), 1, '.', '') . ' ' . $this->getUnit();
    }
}
