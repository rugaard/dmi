<?php

declare(strict_types=1);

namespace Rugaard\DMI\Services;

use Illuminate\Support\Collection;
use Rugaard\DMI\Client;
use Rugaard\DMI\DTO\Radar\Composite;
use Rugaard\DMI\DTO\Radar\PseudoCappi;
use Rugaard\DMI\DTO\Radar\Volume;
use Rugaard\DMI\Enums\Radar\Filters\CompositeFilter;
use Rugaard\DMI\Enums\Radar\Filters\PseudoCappiFilter;
use Rugaard\DMI\Enums\Radar\Filters\VolumeFilter;
use Rugaard\DMI\Enums\Service;
use Rugaard\DMI\Exceptions\ParsingFailedException;

use function array_filter;

use const ARRAY_FILTER_USE_KEY;

/**
 * Class Radar.
 */
class Radar extends Client
{
    /**
     * Download radar file.
     *
     * @param string $filename
     * @return string|null
     * @throws ParsingFailedException
     */
    public function download(string $filename): ?string
    {
        return $this->request(method: 'get', url: 'download/' . $filename);
    }

    /**
     * Get composite radar data features.
     *
     * @param array $filters
     * @return Collection
     * @throws ParsingFailedException
     */
    public function composite(array $filters = []): Collection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => CompositeFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve radar composites data features from API.
        $response = $this->request(method: 'get', url: 'collections/composite/items', query: $filters);

        return Collection::make(items: $response['features'] ?? [])->map(callback: fn (array $item) => Composite::fromGeoJson(payload: $item));
    }

    /**
     * Get composite radar data features by ID.
     *
     * @param string $id
     * @return Composite|null
     * @throws ParsingFailedException
     */
    public function compositeById(string $id): ?Composite
    {
        // Retrieve radar composite data features by ID from API.
        $response = $this->request(method: 'get', url: 'collections/composite/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return Composite::fromGeoJson(payload: $response);
    }

    /**
     * Get pseudo CAPPI radar data features.
     *
     * @param array $filters
     * @return Collection
     * @throws ParsingFailedException
     */
    public function pseudoCappi(array $filters = []): Collection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => PseudoCappiFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve pseudo cappi radar data features from API.
        $response = $this->request(method: 'get', url: 'collections/pseudoCappi/items', query: $filters);

        return Collection::make(items: $response['features'] ?? [])->map(callback: fn (array $item) => PseudoCappi::fromGeoJson(payload: $item));
    }

    /**
     * Get pseudo CAPPI radar data features by ID.
     *
     * @param string $id
     * @return PseudoCappi|null
     * @throws ParsingFailedException
     */
    public function pseudoCappiById(string $id): ?PseudoCappi
    {
        // Retrieve pseudo cappi radar data features by ID from API.
        $response = $this->request(method: 'get', url: 'collections/pseudoCappi/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return PseudoCappi::fromGeoJson(payload: $response);
    }

    /**
     * Get volume radar data features.
     *
     * @param array $filters
     * @return Collection
     * @throws ParsingFailedException
     */
    public function volume(array $filters = []): Collection
    {
        // Only allow supported filters.
        $filters = array_filter(array: $filters, callback: fn (string $key) => VolumeFilter::tryFrom(value: $key), mode: ARRAY_FILTER_USE_KEY);

        // Retrieve volume radar data features from API.
        $response = $this->request(method: 'get', url: 'collections/volume/items', query: $filters);

        return Collection::make(items: $response['features'] ?? [])->map(callback: fn (array $item) => Volume::fromGeoJson(payload: $item));
    }

    /**
     * Get volume radar data features by ID.
     *
     * @param string $id
     * @return Volume|null
     * @throws ParsingFailedException
     */
    public function volumeById(string $id): ?Volume
    {
        // Retrieve volume radar data features by ID from API.
        $response = $this->request(method: 'get', url: 'collections/volume/items/' . $id);

        // Validate response.
        if (empty($response)) {
            return null;
        }

        return Volume::fromGeoJson(payload: $response);
    }

    /**
     * Get service name.
     *
     * @return Service
     */
    public function service(): Service
    {
        return Service::Radar;
    }

    /**
     * Get service version.
     *
     * @return string
     */
    public function serviceVersion(): string
    {
        return '1';
    }
}
