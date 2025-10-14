<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support;

use GeoJson\Exception\UnserializationException;
use GeoJson\Feature\Feature as GeoJsonFeature;
use GeoJson\GeoJson;
use Illuminate\Support\Arr;

/**
 * Trait FromGeoJson.
 */
trait FromGeoJson
{
    /**
     * Create DTO from GeoJson payload.
     *
     * @static
     * @param array $payload
     * @return self
     */
    public static function fromGeoJson(array $payload): self
    {
        try {
            /** @var GeoJsonFeature $feature */
            $feature = GeoJson::jsonUnserialize(json: $payload);
        } catch (UnserializationException) {
            return new static(data: $payload);
        }

        // Build custom data array.
        $data = [
            'id' => $feature->getId(),
            'location' => $feature->getGeometry(),
            'boundingBox' => $feature->getBoundingBox(),
            'crs' => $feature->getCrs(),
            ...$feature->getProperties(),
        ];

        // Add support for STAC properties.
        if (Arr::has(array: $payload, keys: ['stac_version'])) {
            Arr::set(array: $data, key: 'stac', value: [
                'version' => $payload['stac_version'],
                'collection' => $payload['collection'],
                'asset' => $payload['asset'],
            ]);
        }

        // Build DTO.
        return new static(data: $data);
    }
}
