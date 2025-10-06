<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Oceanographic\Filters;

/**
 * Enum TidewaterStationFilter.
 *
 * @return string
 */
enum TidewaterStationFilter: string
{
    case BoundingBox = 'bbox';
    case BoundingBoxCRS = 'bbox-crs';
    case Limit = 'limit';
    case Offset = 'offset';
    case StationId = 'stationId';
}
