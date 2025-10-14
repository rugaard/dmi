<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\DTO;
use Rugaard\DMI\Enums\GeometryType;

/**
 * Class Location.
 */
class Location extends DTO
{
    /**
     * Geometry type of coordinates.
     *
     * @var GeometryType
     */
    public GeometryType $type;

    /**
     * Coordinate of location.
     *
     * @var Collection
     */
    public Collection $coordinates;

    /**
     * Location constructor.
     *
     * @param array|Collection $data
     */
    public function __construct(array|Collection $data)
    {
        // Ignore parent constructor.
        parent::__construct(data: []);

        // Make sure data is always a Collection.
        $data = Collection::wrap(value: $data);

        // Set location type.
        $this->type = $type = GeometryType::tryFrom(value: (string) $data->get(key: 'type'));

        // Parse coordinates depending on geometry type.
        match ($type) {
            GeometryType::Point => $this->parseAsSingular(coordinates: $data->get(key: 'coordinates')),
            GeometryType::LineString => $this->parseAsArray(coordinates: $data->get(key: 'coordinates')),
            default => $this->parseAsNestedArray(coordinates: $data->get(key: 'coordinates'))
        };
    }

    /**
     * Parse coordinates as a nested array.
     *
     * @param array $coordinates
     * @return void
     */
    protected function parseAsNestedArray(array $coordinates): void
    {
        $this->coordinates = Collection::wrap(value: $coordinates)
            ->map(callback: fn (array $groupedCoordinates) => Collection::make(items: $groupedCoordinates)
                ->map(callback: fn (array $coordinate) => new Coordinate(data: $coordinate)));
    }

    /**
     * Parse coordinates as an array.
     *
     * @param array $coordinates
     * @return void
     */
    protected function parseAsArray(array $coordinates): void
    {
        $this->coordinates = Collection::wrap(value: $coordinates)
            ->map(callback: fn (array $coordinate) =>  new Coordinate(data: $coordinate));
    }

    /**
     * Parse coordinates as a single coordinate.
     *
     * @param array $coordinates
     * @return void
     */
    protected function parseAsSingular(array $coordinates): void
    {
        $this->coordinates = Collection::wrap(value: new Coordinate(data: $coordinates));
    }
}
