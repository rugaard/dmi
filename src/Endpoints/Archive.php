<?php
declare(strict_types=1);

namespace Rugaard\DMI\Endpoints;

use DateTime;
use Rugaard\DMI\Contracts\Unit;
use Rugaard\DMI\DTO\Archive\Parameter;
use Tightenco\Collect\Support\Collection;

/**
 * Class Archive
 *
 * @package Rugaard\DMI\Endpoints
 */
class Archive extends AbstractEndpoint
{
    /**
     * Archive type.
     *
     * @var string
     */
    protected $type;

    /**
     * Archive frequency.
     *
     * @var string
     */
    protected $frequency;

    /**
     * Archive period.
     *
     * @var \DateTime
     */
    protected $period;

    /**
     * Area name.
     *
     * @var string|null
     */
    protected $area;

    /**
     * Unit of data.
     *
     * @var \Rugaard\DMI\Contracts\Unit|null
     */
    protected $unit;

    /**
     * Archive constructor.
     *
     * @param string    $type
     * @param string    $frequency
     * @param \DateTime $period
     * @param array     $data
     */
    public function __construct(string $type, string $frequency, DateTime $period, array $data)
    {
        $this->setType($type)
             ->setFrequency($frequency)
             ->setPeriod($period)
             ->setArea($data[0]['area'] ?? $data['area'] ?? null);

        parent::__construct($data);
    }

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void
    {
        if (empty($data)) {
            return;
        }

        // Collection of parameters.
        $parameters = Collection::make();

        // If "$data" does not contain a "dataserie",
        // it means we have multiple measurement parameters.
        if (!isset($data['dataserie'])) {
            // Set unit of archived data.
            $this->setUnit(getUnitByAbbreviation($data[0]['unit']));

            foreach ($data as $parameter) {
                // Parameter ID.
                $parameterId = $parameter['dataserie'][0]['parameterNumber'] ?? getMeasurementParameterByKey($this->getType())->get('id');

                // Add parameter to collection.
                $parameters->push(
                    (new Parameter($parameterId, $parameter))->setImageUrl($this->getFrequency(), $this->getPeriod())
                );
            }
        } elseif (!empty($data['dataserie'])) {
            // Set unit of archived data.
            $this->setUnit(getUnitByAbbreviation($data['unit']));

            // Parameter ID.
            $parameterId = $data['dataserie']['parameterNumber'] ?? getMeasurementParameterByKey($this->getType())->get('id');

            // Add parameter to collection.
            $parameters->push(
                (new Parameter($parameterId, $data))->setImageUrl($this->getFrequency(), $this->getPeriod())
            );
        }

        // Set data with parameters.
        $this->data = $parameters;
    }

    /**
     * Set type of archive.
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
     * Get archive type.
     *
     * @return string|null
     */
    public function getType() :? string
    {
        return $this->type;
    }

    /**
     * Set frequency.
     *
     * @param  string $frequency
     * @return $this
     */
    public function setFrequency(string $frequency) : self
    {
        $this->frequency = $frequency;
        return $this;
    }

    /**
     * Get frequency.
     *
     * @return string
     */
    public function getFrequency() : string
    {
        return $this->frequency;
    }

    /**
     * Set period.
     *
     * @param  \DateTime $period
     * @return $this
     */
    public function setPeriod(DateTime $period) : self
    {
        $this->period = $period;
        return $this;
    }

    /**
     * Get period.
     *
     * @return \DateTime
     */
    public function getPeriod() : DateTime
    {
        return $this->period;
    }

    /**
     * Set area of archive.
     *
     * @param  string|null $area
     * @return $this
     */
    public function setArea(?string $area) : self
    {
        $this->area = $area;
        return $this;
    }

    /**
     * Get archive area.
     *
     * @return string|null
     */
    public function getArea() :? string
    {
        return $this->area;
    }

    /**
     * Set unit of archived data.
     *
     * @param \Rugaard\DMI\Contracts\Unit|null $unit
     * @return $this
     */
    public function setUnit(?Unit $unit) : self
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Get unit of archived data.
     *
     * @return \Rugaard\DMI\Contracts\Unit|null
     */
    public function getUnit() :? Unit
    {
        return $this->unit;
    }
}