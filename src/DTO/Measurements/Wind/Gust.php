<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Measurements\Wind;

use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\AbstractDTO;
use Rugaard\DMI\DTO\Units\Speed\MetersPerSecond;

/**
 * Class Gust.
 *
 * @package Rugaard\DMI\DTO\Measurements\Wind
 */
class Gust extends AbstractDTO
{
    /**
     * Wind speed value.
     *
     * @var float|null
     */
    protected $value;

    /**
     * Unit type.
     *
     * @var \Rugaard\DMI\Contracts\Unit|null
     */
    protected $unit;

    /**
     * Gust constructor.
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
        $this->setValue($data['windGust'] ?? null);
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