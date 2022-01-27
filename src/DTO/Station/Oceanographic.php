<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO\Station;

/**
 * Class Oceanographic.
 *
 * @package Rugaard\DMI\DTO\Station
 */
class Oceanographic extends Meteorological
{
    /**
     * Instrument parameter.
     *
     * @var array
     */
    protected array $instrumentParameter;

    /**
     * Parse data.
     *
     * @param array $data
     */
    public function parse(array $data): void
    {
        parent::parse($data);

        if (!empty($data['properties']['instrumentParameter'])) {
            $this->setInstrumentParameter($data['properties']['instrumentParameter']);
        }
    }

    /**
     * Set instrument parameter.
     *
     * @param array $instrumentParameter
     * @return $this
     */
    public function setInstrumentParameter(array $instrumentParameter): self
    {
        $this->instrumentParameter = $instrumentParameter;
        return $this;
    }

    /**
     * Get instrument parameter.
     *
     * @return array
     */
    public function getInstrumentParameter(): array
    {
        return $this->instrumentParameter;
    }
}
