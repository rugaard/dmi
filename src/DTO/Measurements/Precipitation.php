<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements;

use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Units\Length\Millimeter;

/**
 * Class Precipitation.
 *
 * @package Rugaard\DMI\DTO\Measurements
 */
class Precipitation extends AbstractDTO
{
    /**
     * Precipitation type.
     *
     * @var string|null
     */
    protected $type;

    /**
     * Predicted/expected amount.
     *
     * @var float|null
     */
    protected $value = 0.0;

    /**
     * Lowest predicted amount (uncertain).
     *
     * @var float
     */
    protected $lowestValue = 0.0;

    /**
     * Highest predicted amount (uncertain).
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
     * Precipitation constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Set default unit.
        $this->setUnit(new Millimeter);

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
        $this->setType($data['precipType'])
             ->setValue((float) ($data['prec50'] ?? $data['precip3'] ?? null));

        if (!empty($data['prec50'])) {
            $this->setLowestValue((float) $data['prec10'])
                 ->setHighestValue((float) $data['prec90']);
        }
    }

    /**
     * Set precipitation type.
     *
     * @param  string $type
     * @return $this
     */
    public function setType(string $type) : self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get precipitation type.
     *
     * @return string|null
     */
    public function getType() :? string
    {
        return $this->type;
    }

    /**
     * Set precipitation value.
     *
     * @param  float|null $value
     * @return $this
     */
    public function setValue(?float $value) : self
    {
        $this->value = (float) ($value < 0.1 ? 0.0 : $value);
        return $this;
    }

    /**
     * Get precipitation value.
     *
     * @return float|null
     */
    public function getValue() :? float
    {
        return $this->value;
    }

    /**
     * Set lowest predicted amount (uncertain).
     *
     * @param  float|null $value
     * @return $this
     */
    public function setLowestValue(?float $value) : self
    {
        $this->lowestValue = (float) ($value < 0.1 ? 0.0 : $value);
        return $this;
    }

    /**
     * Get lowest predicted amount (uncertain).
     *
     * @return float|null
     */
    public function getLowestValue() :? float
    {
        return $this->lowestValue;
    }

    /**
     * Set highest predicted amount (uncertain).
     *
     * @param  float|null $value
     * @return $this
     */
    public function setHighestValue(?float $value) : self
    {
        $this->highestValue = (float) ($value < 0.1 ? 0 : $value);
        return $this;
    }

    /**
     * Get highest predicted amount (uncertain).
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