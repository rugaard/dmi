<?php

declare(strict_types=1);

namespace Rugaard\DMI\Enums;

/**
 * Enum GeometryType.
 */
enum GeometryType: string
{
    case Point = 'Point';
    case MultiPoint = 'MultiPoint';
    case LineString = 'LineString';
    case MultiLineString = 'MultiLineString';
    case Polygon = 'Polygon';
    case MultiPolygon = 'MultiPolygon';
}
