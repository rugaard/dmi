<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Illuminate\Support\Collection;
use Rugaard\DMI\Abstracts\DTO;

/**
 * Class STAC.
 */
class STAC extends DTO
{
    /**
     * STAC version.
     *
     * @var string
     */
    public string $version;

    /**
     * Collection name or ID.
     *
     * @var string
     */
    public string $collection;

    /**
     * STAC asset.
     *
     * @var Collection
     */
    public Collection $asset;
}
