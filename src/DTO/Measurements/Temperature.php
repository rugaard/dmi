<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements;

use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Units\Temperature\Celsius;

/**
 * Class Temperature.
 *
 * @package Rugaard\DMI\DTO\Measurements
 */
class Temperature extends AbstractDTO
{
    /**
     * Predicted/expected temperature.
     *
     * @var float|null
     */
    protected $value;

    /**
     * Lowest predicted temperature (uncertain).
     *
     * @var float|null
     */
    protected $lowestValue;

    /**
     * Highest predicted temperature (uncertain).
     *
     * @var float|null
     */
    protected $highestValue;

    /**
     * Unit type.
     *
     * @var \Rugaard\DMI\Contracts\Unit|null
     */
    protected $unit;

    /**
     * Temperature constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Set default unit.
        $this->setUnit(new Celsius);

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
        // If "temp50" is empty,
        // then we know EPS is not available.
        if (!empty($data['temp50'])) {
            $this->setValue($data['temp50'] ?? null)
                 ->setLowestValue($data['temp10'] ?? null)
                 ->setHighestValue($data['temp90'] ?? null);
        } else {
            $this->setValue($data['temp'] ?? null);
        }
    }

    /**
     * Set temperature value.
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
     * Get temperature value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set lowest predicted temperature (uncertain).
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
     * Get lowest predicted temperature (uncertain).
     *
     * @return float|null
     */
    public function getLowestValue() :? float
    {
        return $this->lowestValue;
    }

    /**
     * Set highest predicted temperature (uncertain).
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
     * Get highest predicted temperature (uncertain).
     *
     * @return float|null
     */
    public function getHighestValue() :? float
    {
        return $this->highestValue;
    }

    /**
     * Set temperature unit.
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
     * Get temperature unit.
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
        return floor($this->getValue()) . $this->getUnit();
    }
}