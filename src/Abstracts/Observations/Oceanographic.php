<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts\Observations;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\Observation;
use Rugaard\DMI\Enums\Oceanographic\Parameter as OceanographicType;
use Rugaard\DMI\Enums\Oceanographic\QualityControl;
use Rugaard\DMI\Enums\QualityControlStatus;
use Rugaard\DMI\Support\Attributes\ObservedTimestamp as HasObservedTimestamp;

/**
 * Class Meteorological.
 */
abstract class Oceanographic extends Observation
{
    use HasObservedTimestamp;

    /**
     * ID of observation station.
     *
     * @var string
     */
    public string $stationId;

    /**
     * Observation parameter.
     *
     * @var OceanographicType
     */
    public OceanographicType $parameter;

    /**
     * Description of observation.
     *
     * @var string
     */
    public string $description;

    /**
     * Quality control of observation.
     *
     * @var Collection
     */
    public Collection $qualityControl;

    /**
     * Oceanographic constructor.
     *
     * @param array|Collection $data
     */
    public function __construct(array|Collection $data)
    {
        // Make sure data is always a Collection.
        $data = Collection::wrap($data);

        // A little workaround to merge quality control fields.
        parent::__construct(data: $data->except(keys: ['qcStatus', 'qcResult'])->put(
            key: 'qualityControl',
            value: [
                'status' => $data->get(key: 'qcStatus', default: 'none'),
                'result' => $data->get(key: 'qcResult'),
            ]
        ));
    }

    /**
     * Set parameter and description from parameter ID.
     *
     * @param string $parameterId
     * @return $this
     */
    protected function setParameterId(string $parameterId): self
    {
        // Get parameter from parameter ID.
        $parameter = $this->parameter = OceanographicType::from(value: $parameterId);

        // Set observation description from parameter.
        $this->description = $parameter->description();

        return $this;
    }

    /**
     * Set quality control.
     *
     * @param Collection $qualityControl
     * @return $this
     */
    protected function setQualityControl(Collection $qualityControl): self
    {
        // Extract values from collection.
        $status = $qualityControl->get(key: 'status', default: 'none');
        $result = $qualityControl->get(key: 'result');

        // Set quality control.
        $this->qualityControl = Collection::make(items: [
            'status' => QualityControlStatus::from(value: $status),
            'result' => $status !== 'none' ? ($result !== null && $result > 0 ? QualityControl::from(value: (int) $result) : QualityControl::OK) : null,
        ]);

        return $this;
    }
}
