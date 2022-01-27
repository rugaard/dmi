<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use function is_array;

/**
 * Class Location.
 *
 * @package Rugaard\DMI\DTO
 */
class Location
{
    /**
     * Type of location.
     *
     * @var string
     */
    protected string $type;

    /**
     * Coordinates of location.
     *
     * @var array
     */
    protected array $coordinates;

    /**
     * Location constructor.
     *
     * @param ...$data
     */
    public function __construct(...$data)
    {
        // Support old school arrays.
        if (is_array($data[0] ?? null)) {
            $data = $data[0];
        }

        $this->type = (string) $data['type'];
        $this->coordinates = (array) ($data['coordinates'] ?? []);
    }
}
