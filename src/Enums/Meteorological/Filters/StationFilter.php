<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Meteorological\Filters;

/**
 * Enum StationFilter.
 *
 * @return string
 */
enum StationFilter: string
{
    case BoundingBox = 'bbox';
    case BoundingBoxCRS = 'bbox-crs';
    case DateTime = 'datetime';
    case Limit = 'limit';
    case Offset = 'offset';
    case StationId = 'stationId';
    case Status = 'status';
    case Type = 'type';
}
