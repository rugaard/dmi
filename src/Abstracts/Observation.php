<?php

declare(strict_types=1);

namespace Rugaard\DMI\Abstracts;

use Rugaard\DMI\Support\Attributes\Location as HasLocation;
use Rugaard\DMI\Support\FromGeoJson;

/**
 * Class Observation.
 */
abstract class Observation extends DTO
{
    use FromGeoJson, HasLocation;

    /**
     * Observation UUID.
     *
     * @var string
     */
    public string $id;
}
