<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\DTO;

/**
 * Class Location.
 */
class Location extends DTO
{
    /**
     * Coordinates type.
     *
     * @var string
     */
    public string $type;

    /**
     * Coordinates of location.
     *
     * @var Collection
     */
    public Collection $coordinates;
}
