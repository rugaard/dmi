<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums\Oceanographic\Filters;

/**
 * Enum TidewaterPredictionFilter.
 *
 * @return string
 */
enum TidewaterPredictionFilter: string
{
    case BoundingBox = 'bbox';
    case BoundingBoxCRS = 'bbox-crs';
    case DateTime = 'datetime';
    case Limit = 'limit';
    case Offset = 'offset';
    case PredictionType = 'predictionType';
    case StationId = 'stationId';
}
