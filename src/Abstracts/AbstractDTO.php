<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use ReflectionClass;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;
use Tightenco\Collect\Support\Arr;
use Tightenco\Collect\Support\Collection;

use function array_filter;
use function array_map;
use function get_class;
use function gettype;
use function in_array;
use function is_array;

/**
 * Class AbstractDTO.
 *
 * @abstract
 * @package Rugaard\DMI\Abstracts
 */
abstract class AbstractDTO
{
    /**
     * AbstractDTO constructor.
     *
     * @param ...$data
     */
    public function __construct(...$data)
    {
        // Support old school arrays.
        if (is_array($data[0] ?? null)) {
            $data = array_shift($data[0]);
        }

        // Reflect self.
        $class = new ReflectionClass($this);

        // Get all public properties.
        $properties = array_filter(
            $class->getProperties(ReflectionProperty::IS_PUBLIC),
            static fn(ReflectionProperty $property) => !$property->isStatic()
        );

        // Loop through public properties
        // and try and set their value.
        foreach ($properties as $property) {
            $value = Arr::get($data, $property->name) ?? $this->{$property->name} ?? null;
            if ($this->validateValue($property, $value)) {
                $property->setValue($this, $value);
            }

            // Remove property from data array.
            Arr::forget($data, $property->name);
        }
    }

    /**
     * Validate value.
     *
     * @param \ReflectionProperty $property
     * @param mixed $value
     * @return bool
     */
    protected function validateValue(ReflectionProperty $property, mixed $value): bool
    {
        // Get property reflection type.
        $propertyType = $property->getType();

        // If no type has been associated with property,
        // we can't properly validate it and will instead
        // just allow whatever value has been provided.
        if (empty($propertyType)) {
            return true;
        }

        // When value is null, check that property allows it.
        // If it does, then accept it immediately.
        if ($value === null && ($propertyType && $propertyType->allowsNull())) {
            return true;
        }

        // Get allowed types for property.
        $allowedTypes = $propertyType instanceof ReflectionUnionType
            ? array_map(static fn(ReflectionNamedType $type) => $type->getName(), $propertyType->getTypes())
            : [$propertyType->getName()];

        // For some random reason,
        // PHP does not the return the
        // abbreviation of some variable types.
        $allowedTypes = array_map(static fn(string $allowedType) => match($allowedType) {
            'int' => 'integer',
            'float' => 'double',
            'bool' => 'boolean',
            default => $allowedType
        }, $allowedTypes);

        // Get type of value.
        $typeOfValue = gettype($value);

        // If value is of type "object",
        // then we can assume that value is a class,
        // and we therefore rather want to use the
        // namespace of the class for validation.
        if ($typeOfValue === 'object') {
            $typeOfValue = get_class($value);
            $typeOfValue = array_merge([$typeOfValue], array_values(class_implements($typeOfValue)), array_values(class_parents($typeOfValue)));
        }

        // Check if type of value is allowed for property.
        $typeOfValue = is_array($typeOfValue) ? $typeOfValue : [$typeOfValue];
        foreach ($typeOfValue as $typeValue) {
            if (in_array($typeValue, $allowedTypes, true)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get values as a collection.
     *
     * @return \Tightenco\Collect\Support\Collection
     */
    public function asCollection(): Collection
    {
        // Reflect self.
        $class = new ReflectionClass(static::class);

        // Get all public properties.
        $properties = array_filter(
            $class->getProperties(ReflectionProperty::IS_PUBLIC),
            static fn(ReflectionProperty $property) => !$property->isStatic()
        );

        // Data container.
        $data = [];

        // Loop through public properties
        // and retrieve their value.
        foreach ($properties as $property) {
            $data[$property->getName()] = $property->getValue($this);
        }

        return Collection::make($data);
    }

    /**
     * Get only selected keys as array.
     *
     * @param ...$keys
     * @return array
     */
    public function only(...$keys): array
    {
        // Support old school arrays.
        if (is_array($keys[0] ?? null)) {
            $keys = $keys[0];
        }

        return $this->asCollection()->only($keys)->toArray();
    }

    /**
     * Get values except selected keys as array.
     *
     * @param ...$keys
     * @return array
     */
    public function except(...$keys): array
    {
        // Support old school arrays.
        if (is_array($keys[0] ?? null)) {
            $keys = $keys[0];
        }
        return $this->asCollection()->except($keys)->toArray();
    }

    /**
     * Get values as array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->asCollection()->toArray();
    }
}
