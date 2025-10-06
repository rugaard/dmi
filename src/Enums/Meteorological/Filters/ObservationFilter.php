<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Meteorological\Filters;

/**
 * Enum ObservationFilter.
 *
 * @return string
 */
enum ObservationFilter: string
{
    case BoundingBox = 'bbox';
    case BoundingBoxCRS = 'bbox-crs';
    case DateTime = 'datetime';
    case Limit = 'limit';
    case Offset = 'offset';
    case ParameterId = 'parameterId';
    case Period = 'period';
    case SortOrder = 'sortorder';
    case StationId = 'stationId';
}
