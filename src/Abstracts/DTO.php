<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use GeoJson\Feature\Feature as GeoJsonFeature;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use ReflectionClass;
use RuntimeException;

use function is_array;
use function json_encode;
use function method_exists;
use function property_exists;

/**
 * Class DTO.
 *
 * @abstract
 */
abstract class DTO implements Arrayable, Jsonable
{
    /**
     * DTO constructor.
     *
     * @param Collection|array $data
     */
    public function __construct(Collection|array $data)
    {
        // Make sure data is a Collection.
        $data = $this->toCamelCollection($data);

        // Parse provided data.
        $data->each(callback: function ($value, $key) {
            $this->__set(name: $key, value: $value);
        });
    }

    /**
     * Force all keys to camel-case and convert all arrays to collections.
     *
     * @param Collection|array $data
     * @return Collection
     */
    protected function toCamelCollection(Collection|array $data): Collection
    {
        // Force data to a Collection.
        $data = Collection::wrap(value: $data);

        // Rename keys to camel-case.
        $data = $data->keys()->map(callback: fn ($key) => Str::camel(value: $key))->combine(values: $data->values());

        // Convert arrays to Collections.
        return $data->map(callback: fn ($item) => is_array(value: $item) ? $this->toCamelCollection(data: $item) : $item);
    }

    /**
     * Get as a Collection.
     *
     * @return Collection
     */
    public function toCollection(): Collection
    {
        // Data container.
        $data = Collection::make();

        // Get class properties.
        $properties = Collection::make(items: (new ReflectionClass($this))->getProperties())->map(callback: fn ($property) => $property->name);

        // Loop through each class property and collect its value.
        foreach ($properties as $property) {
            // Get value of property.
            $value = $this->__get(name: $property);

            // Add value to container.
            $data->put(key: $property, value: ($value instanceof self) ? $value->toArray() : $value);
        }

        return $data;
    }

    /**
     * Get as an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->toCollection()->toArray();
    }

    /**
     * Get as JSON.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0): string
    {
        return json_encode(value: $this->toCollection()->toArray(), flags: $options);
    }

    /**
     * Set property value.
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    public function __set(string $name, mixed $value): void
    {
        if (method_exists(object_or_class: $this, method: 'set' . Str::studly(value: $name))) {
            $this->{'set' . Str::studly(value: $name)}($value);
        } elseif (property_exists(object_or_class: $this, property: Str::camel($name))) {
            $this->{Str::camel($name)} = $value;
        }
    }

    /**
     * Get property value.
     *
     * @param string $name
     * @return mixed
     */
    public function __get(string $name): mixed
    {
        if (method_exists(object_or_class: $this, method: 'get' . Str::studly(value: $name))) {
            return $this->{'get' . Str::studly(value: $name)}();
        } elseif (property_exists(object_or_class: $this, property: Str::camel($name))) {
            return $this->$name;
        }

        throw new RuntimeException(message: '[' . $name . '] does not exist.', code: 500);
    }
}
