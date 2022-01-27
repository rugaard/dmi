<?php

declare(strict_types=1);

namespace Rugaard\DMI\Collections;

use Tightenco\Collect\Support\Collection;

use function explode;

/**
 * Class ObservationsCollection.
 *
 * @package Rugaard\DMI\Collections
 */
class ObservationsCollection extends Collection
{
    /**
     * Group observations by observation type.
     *
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     */
    public function groupByType(): ObservationsCollection
    {
        $results = new static();

        foreach ($this->items as $item) {
            // Get namespace of item type.
            $itemClass = $item::class;

            // Extract type from namespace.
            $itemType = explode('\\', $itemClass)[4];

            // If this is the first item type, then we'll
            // initially add it with an empty collection.
            if (!$results->has($itemType)) {
                $results->put($itemType, Collection::make());
            }

            // If this is the first measurement type, then we'll
            // initially add it with an empty collection.
            if (!$results->get($itemType)->has($item->type->name)) {
                $results->get($itemType)->put($item->type->name, Collection::make());
            }

            // Add item to collection.
            $results->get($itemType)->get($item->type->name)->push($item);
        }

        return $results->count() === 1 ? new static($results->first()) : $results;
    }

    /**
     * Group observations by station.
     *
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     */
    public function groupByStation(): ObservationsCollection
    {
        $results = new static();

        foreach ($this->items as $item) {
            // If this is the first time we're hitting this station,
            // then we'll initially add it with an empty collection.
            if (!$results->has($item->stationId)) {
                $results->put($item->stationId, Collection::make());
            }

            // Add item to station group.
            $results->get($item->stationId)->push($item);
        }

        return $results->count() === 1 ? new static($results->first()) : $results;
    }

    /**
     * Group observations by stations and then group observations
     * by their type inside the grouped stations.
     *
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     */
    public function groupByStationAndType(): ObservationsCollection
    {
        $results = new static();

        foreach ($this->items as $item) {
            // If this is the first time we're hitting this station,
            // then we'll initially add it with an empty collection.
            if (!$results->has($item->stationId)) {
                $results->put($item->stationId, Collection::make());
            }

            // Get namespace of item type.
            $itemClass = $item::class;

            // Extract type from namespace.
            $itemType = explode('\\', $itemClass)[4];

            // If this is the first item type, then we'll
            // initially add it with an empty collection.
            if (!$results->get($item->stationId)->has($itemType)) {
                $results->get($item->stationId)->put($itemType, Collection::make());
            }

            // If this is the first measurement type, then we'll
            // initially add it with an empty collection.
            if (!$results->get($item->stationId)->get($itemType)->has($item->type->name)) {
                $results->get($item->stationId)->get($itemType)->put($item->type->name, Collection::make());
            }

            // Add item to station collection.
            $results->get($item->stationId)->get($itemType)->get($item->type->name)->push($item);
        }

        $results = $results->map(function ($group) {
            return $group->count() === 1 ? $group->first() : $group;
        });

        return $results;
    }

    /**
     * Group observations by observation type, but only return
     * the first observation in each observation group.
     *
     * @return \Rugaard\DMI\Collections\ObservationsCollection
     */
    public function onlyFirstByType(): ObservationsCollection
    {
        return $this->groupByType()->map(function ($group, $groupName) {
            // Weather Condition does not have multiple
            // types of measurements.
            if ($groupName === 'WeatherCondition') {
                return $group->first();
            }

            return $group->map(function ($items) {
                return $items->first();
            });
        });
    }
}
