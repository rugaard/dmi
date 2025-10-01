<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use GeoJson\Feature\Feature;
use Illuminate\Support\Collection;
use Rugaard\DMI\Client;
use Rugaard\DMI\Collections\ObservationCollection;
use Rugaard\DMI\Enums\Meteorological\ObservationFilter;
use Rugaard\DMI\Enums\Meteorological\Parameter;
use Rugaard\DMI\Enums\Meteorological\StationFilter;
use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\ParsingFailedException;
use ValueError;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

/**
 * Class Meteorological.
 */
class Meteorological extends Client
{

    /**
     * Get all observation stations.
     *
     * @param array $filters
     * @return array
     * @throws ParsingFailedException
     */
    public function stations(array $filters = []): array
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => StationFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        return $this->request(method: 'get', url: 'station/items', query: $filters);
    }

    /**
     * Get all observations.
     *
     * @param array $filters
     * @return Collection
     * @throws ParsingFailedException
     */
    public function observations(array $filters = []): Collection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => ObservationFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Always sort by latest observation,
        // unless specified otherwise.
        $filters = ['sortorder' => 'observed,DESC', ...$filters];

        // Retrieve observations from API.
        $response = $this->request(method: 'get', url: 'observation/items', query: $filters);

        // Parse each observation and return it as a Collection.
        return ObservationCollection::make(items: $response)->map(callback: static function (Feature $item) {
            try {
                // Get meteorological parameter from payload.
                $parameter = Parameter::from(value: $item->getProperties()['parameterId'] ?? null);
                return $parameter->dto()::fromGeoJson(feature: $item);
            } catch (ValueError) {
                // Should we for some reason hit an unsupported parameter,
                // then we'll jump ship and return null, so we can remove it later.
                return null;
            }
        })->filter()->onlyFirstByType();
    }

    /**
     * Get service name.
     *
     * @return Service
     */
    public function service(): Service
    {
        return Service::Meteorological;
    }

    /**
     * Get service version.
     *
     * @return string
     */
    public function serviceVersion(): string
    {
        return '2';
    }
}
