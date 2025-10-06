<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Lightning;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observations\Lightning as LightningObservation;
use Rugaard\DMI\Enums\Lightning\LightningType;

use function explode;

/**
 * Class Lightning.
 */
class Lightning extends LightningObservation
{
    /**
     * Type of lightning.
     *
     * @var LightningType
     */
    public LightningType $type;

    /**
     * Description of lightning type.
     *
     * @var string
     */
    public string $description;

    /**
     * ID of sensors which registered the lightning stroke.
     *
     * Note: Does not include 3rd party sensors, used for triangulation purposes.
     *
     * @var Collection
     */
    public Collection $sensorIds;

    /**
     * Set type of lightning.
     *
     * @param float $value
     * @return $this
     */
    public function setType(float $value): self
    {
        // Determine type of lightning.
        $this->type = $type = LightningType::from((int) $value);

        // Set description of lightning.
        $this->description = $type->description();

        return $this;
    }

    /**
     * Set ID of sensors which registered the lightning stroke.
     *
     * @param string $sensorIds
     * @return $this
     */
    public function setSensors(string $sensorIds): self
    {
        $this->sensorIds = Collection::make(items: explode(separator: ',', string: $sensorIds))->map(fn (string $sensorId) => (int) $sensorId);
        return $this;
    }
}
