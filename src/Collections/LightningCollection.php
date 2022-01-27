<?php

declare(strict_types=1);

namespace Rugaard\DMI\Collections;

use Tightenco\Collect\Support\Collection;

/**
 * Class LightningCollection.
 *
 * @package Rugaard\DMI\Collections
 */
class LightningCollection extends Collection
{
    /**
     * Group by lightning type.
     *
     * @return \Rugaard\DMI\Collections\LightningCollection
     */
    public function groupByType(): LightningCollection
    {
        $results = new static();

        foreach ($this->items as $item) {
            // If this is the first measurement type, then we'll
            // initially add it with an empty collection.
            if (!$results->has($item->type->name)) {
                $results->put($item->type->name, Collection::make());
            }

            // Add item to collection.
            $results->get($item->type->name)->push($item);
        }

        return $results;
    }

    /**
     * Group by lightning type, but only return the first
     * lightning in each group.
     *
     * @return \Rugaard\DMI\Collections\LightningCollection
     */
    public function onlyFirstByType(): LightningCollection
    {
        return $this->groupByType()->map(function ($items) {
            return $items->first();
        });
    }
}
