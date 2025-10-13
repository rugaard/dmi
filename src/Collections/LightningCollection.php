<?php

declare(strict_types=1);

namespace Rugaard\DMI\Collections;

use Illuminate\Support\Collection;
use Rugaard\DMI\DTO\Lightning\Lightning;
use Rugaard\DMI\DTO\Lightning\Sensor;

/**
 * Class LightningCollection.
 */
class LightningCollection extends Collection
{
    /**
     * Group lightning/sensor data by lightning type.
     *
     * @return $this
     */
    public function groupByType(): self
    {
        /** @var LightningCollection<string, Collection<int, Lightning|Sensor>> $items */
        $items = new static();

        foreach ($this->items as $item) {
            // If this is the first measurement type, then we'll
            // initially add it with an empty collection.
            if (!$items->has(key: $item->type->name)) {
                $items->put(key: $item->type->name, value: Collection::make());
            }

            // Add item to collection.
            $items->get(key: $item->type->name)->push(value: $item);
        }

        return $items;
    }

    /**
     * Group lightning/sensor data by lightning type,
     * but only return the first item from each type.
     *
     * @return $this
     */
    public function onlyFirstByType(): self
    {
        return $this->groupByType()->map(fn ($items) => $items->first());
    }
}
