<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Radar\Filters;

/**
 * Enum CompositeFilter.
 *
 * @return string
 */
enum CompositeFilter: string
{
    case BoundingBox = 'bbox';
    case BoundingBoxCRS = 'bbox-crs';
    case DateTime = 'datetime';
    case Limit = 'limit';
    case Offset = 'offset';
    case ScanType = 'scanType';
    case SortOrder = 'sortorder';
}
