<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Lightning\Filters;

/**
 * Enum ObservationSensorFilter.
 *
 * @return string
 */
enum ObservationSensorFilter: string
{
    case BoundingBox = 'bbox';
    case BoundingBoxCRS = 'bbox-crs';
    case DateTime = 'datetime';
    case Limit = 'limit';
    case Offset = 'offset';
    case Period = 'period';
    case SortOrder = 'sortorder';
    case StationId = 'stationId';
    case Type = 'type';
}
