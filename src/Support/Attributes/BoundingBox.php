<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use GeoJson\BoundingBox as GeoJsonBoundingBox;
use Rugaard\DMI\DTO\BoundingBox as BoundingBoxDTO;

/**
 * Trait BoundingBox.
 */
trait BoundingBox
{
    /**
     * Bounding box of object.
     *
     * @var BoundingBoxDTO|null
     */
    public ?BoundingBoxDTO $boundingBox;

    /**
     * Set bounding box of object.
     *
     * @param GeoJsonBoundingBox $box
     * @return $this
     */
    protected function setBoundingBox(GeoJsonBoundingBox $box): self
    {
        $this->boundingBox = new BoundingBoxDTO(data: $box->getBounds());
        return $this;
    }
}
