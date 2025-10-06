<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Oceanographic;

use DateTime;
use DateTimeZone;
use Exception;
use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Enums\Oceanographic\PredictionType;
use Rugaard\DMI\Units\Length\Centimeter;

/**
 * Class Tidewater.
 */
class Tidewater extends Observation
{
    /**
     * Type of prediction.
     *
     * @var PredictionType
     */
    public PredictionType $predictionType;

    /**
     * Description of prediction type.
     *
     * @var string
     */
    public string $description;

    /**
     * Timestamp of prediction value.
     *
     * @var DateTime
     */
    public DateTime $predictionTimestamp;

    /**
     * Value of prediction.
     *
     * @var float
     */
    public float $value;

    /**
     * Unit of value.
     *
     * @var Centimeter
     */
    public Centimeter $unit;

    /**
     * Tidewater constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        parent::__construct(data: $data);

        // Set internal unit.
        $this->unit = new Centimeter;
    }

    /**
     * Set prediction type and description.
     *
     * @param string $predictionType
     * @return $this
     */
    protected function setPredictionType(string $predictionType): self
    {
        // Get prediction type.
        $parameter = $this->predictionType = PredictionType::from(value: $predictionType);

        // Set description from prediction type.
        $this->description = $parameter->description();

        return $this;
    }

    /**
     * Set timestamp of prediction value.
     *
     * @param string $datetime
     * @return $this
     * @throws Exception
     */
    protected function setPredictionTime(string $datetime): self
    {
        $this->predictionTimestamp = (new DateTime(datetime: $datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC'));
        return $this;
    }

    /**
     * Set timestamp of when prediction was created.
     *
     * @param string $datetime
     * @return $this
     * @throws Exception
     */
    protected function setCreated(string $datetime): self
    {
        $this->timestamp = (new DateTime(datetime: $datetime))->setTimezone(timezone: new DateTimeZone(timezone: 'UTC'));
        return $this;
    }
}
