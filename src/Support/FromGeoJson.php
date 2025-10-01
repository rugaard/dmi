<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support;

use GeoJson\Feature\Feature as GeoJsonFeature;

/**
 * Trait FromGeoJson.
 */
trait FromGeoJson
{
    /**
     * Create DTO from GeoJson object.
     *
     * @static
     * @param GeoJsonFeature $feature
     * @return self
     */
    public static function fromGeoJson(GeoJsonFeature $feature): self
    {
        return new static(data: [
            'id' => $feature->getId(),
            'location' => $feature->getGeometry(),
            'boundingBox' => $feature->getBoundingBox(),
            'crs' => $feature->getCrs(),
            ...$feature->getProperties(),
        ]);
    }
}
