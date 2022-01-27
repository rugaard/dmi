<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Tightenco\Collect\Support\Collection;

/**
 * Class Observations.
 *
 * @package Rugaard\DMI\DTO
 */
abstract class Observations extends DTO
{
    /**
     * Collection of observations.
     *
     * @var \Tightenco\Collect\Support\Collection
     */
    protected Collection $data;

    /**
     * Group data by observation type.
     *
     * @var bool
     */
    protected bool $group = false;

    /**
     * Only return one of each observation parameter.
     *
     * @var bool
     */
    protected bool $onlyOneEach = false;

    /**
     * Observations constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        // Create empty data collection.
        $this->data = Collection::make();

        parent::__construct($data);
    }

    /**
     * Get collection of observations.
     *
     * @return \Tightenco\Collect\Support\Collection
     */
    public function get(): Collection
    {
        $data = $this->data;

        if ($this->onlyOneEach) {
            $data = $this->filterOnlyOneEach($data);
        }

        if ($this->group) {
            $data = $this->groupData($data);
        }

        return $data;
    }

    /**
     * Group data by observation type.
     *
     * @return $this
     */
    public function group(): self
    {
        $this->group = true;
        return $this;
    }

    /**
     * Group data by observation types.
     *
     * @param \Tightenco\Collect\Support\Collection $data
     * @return \Tightenco\Collect\Support\Collection
     */
    private function groupData(Collection $data): Collection
    {
        $groupedData = Collection::make();

        $data->each(function ($item) use (&$groupedData) {
            // Get observation type.
            $observationType = strtolower(substr(get_class($item), strrpos(get_class($item), '\\') + 1));

            // If observation group type doesn't exist
            // then we'll add it with an empty Collection.
            if (!$groupedData->has($observationType)) {
                $groupedData->put($observationType, Collection::make());
            }

            // If observation type doesn't exist,
            // we'll add it to the observation group
            // with an empty Collection.
            if (!$groupedData[$observationType]->has($item->getType())) {
                $groupedData[$observationType]->put($item->getType(), Collection::make());
            }

            $groupedData[$observationType][$item->getType()]->push($item);
        });

        return $groupedData->sortKeys()->map(function ($group) {
            return $group->sortKeys();
        });
    }

    /**
     * Only return one of each observation parameter.
     *
     * @return $this
     */
    public function onlyOneEach(): self
    {
        $this->onlyOneEach = true;
        return $this;
    }

    /**
     * Filter data set, so we only return one of each
     * observation parameter.
     *
     * @param \Tightenco\Collect\Support\Collection $data
     * @return \Tightenco\Collect\Support\Collection
     */
    private function filterOnlyOneEach(Collection $data): Collection
    {
        // Container of parsed parameters.
        $parameters = Collection::make();

        return $data->filter(function ($item) use (&$parameters) {
            // If parameter ID already exists,
            // then we'll remove it from our Collection.
            if ($parameters->contains($item->getId())) {
                return false;
            }

            // Add parameter ID to our container of parsed parameters,
            // so we won't add it again later.
            $parameters->push($item->getId());

            return true;
        })->values();
    }
}
