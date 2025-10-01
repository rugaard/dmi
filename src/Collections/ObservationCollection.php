<?php

declare(strict_types=1);

namespace Rugaard\DMI\Collections;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\DTO;

use function array_pop;
use function explode;

/**
 * Class ObservationCollection.
 */
class ObservationCollection extends Collection
{
    /**
     * Group observations by observation type.
     *
     * @return $this
     */
    public function groupByType(): self
    {
        /** @var ObservationCollection<string, Collection<int, DTO>> $items */
        $items = new static();

        foreach ($this->items as $item) {
            // Split namespace of item.
            $itemClass = explode(separator: '\\', string: $item::class);

            // Extract type from namespace.
            $itemType = array_pop(array: $itemClass);

            // If this is the first item type, then we'll
            // initially add it with an empty collection.
            if (!$items->has(key: $itemType)) {
                $items->put(key: $itemType, value: Collection::make());
            }

            // If this is the first measurement type, then we'll
            // initially add it with an empty collection.
            if (!$items->get(key: $itemType)->has(key: $item->parameter->name)) {
                $items->get(key: $itemType)->put(key: $item->parameter->name, value: Collection::make());
            }

            // Add item to collection.
            $items->get(key: $itemType)->get(key: $item->parameter->name)->push(value: $item);
        }

        return $items->count() === 1 ? new static(items: $items->first()) : $items;
    }

    /**
     * Group observations by station.
     *
     * @return $this
     */
    public function groupByStation(): self
    {
        /** @var ObservationCollection<string, Collection<int, DTO>> $items */
        $items = new static();

        foreach ($this->items as $item) {
            // If this is the first time we're hitting this station,
            // then we'll initially add it with an empty collection.
            if (!$items->has(key: $item->stationId)) {
                $items->put(key: $item->stationId, value: Collection::make());
            }

            // Add item to station group.
            $items->get(key: $item->stationId)->push(value: $item);
        }

        return $items->count() === 1 ? new static(items: $items->first()) : $items;
    }

    /**
     * Group observations by stations and then group observations
     * by their type inside the grouped stations.
     *
     * @return $this
     */
    public function groupByStationAndType(): self
    {
        /** @var ObservationCollection<string, Collection<int, DTO>> $items */
        $items = new static();

        foreach ($this->items as $item) {
            // If this is the first time we're hitting this station,
            // then we'll initially add it with an empty collection.
            if (!$items->has(key: $item->stationId)) {
                $items->put(key: $item->stationId, value: Collection::make());
            }

            // Split namespace of item.
            $itemClass = explode(separator: '\\', string: $item::class);

            // Extract type from namespace.
            $itemType = array_pop(array: $itemClass);

            // If this is the first item type, then we'll
            // initially add it with an empty collection.
            if (!$items->get(key: $item->stationId)->has(key: $itemType)) {
                $items->get(key: $item->stationId)->put(key: $itemType, value: Collection::make());
            }

            // If this is the first measurement type, then we'll
            // initially add it with an empty collection.
            if (!$items->get(key: $item->stationId)->get(key: $itemType)->has(key: $item->parameter->name)) {
                $items->get(key: $item->stationId)->get(key: $itemType)->put(key: $item->parameter->name, value: Collection::make());
            }

            // Add item to station collection.
            $items->get(key: $item->stationId)->get(key: $itemType)->get(key: $item->parameter->name)->push(value: $item);
        }

        return $items->map(fn ($group) => $group->count() === 1 ? $group->first() : $group);
    }

    /**
     * Group observations by observation type,
     * but only return the first observation from each type.
     *
     * @return $this
     */
    public function onlyFirstByType(): self
    {
        // Weather Condition does not have multiple types of measurements.
        return $this->groupByType()->map(fn ($group, $groupName) => $groupName === 'WeatherCondition'
            ? $group->first()->first()
            : $group->map(fn ($items) => $items->first())
        );
    }
}
