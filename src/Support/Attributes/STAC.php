<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

use Illuminate\Support\Collection;
use Rugaard\DMI\DTO\STAC as STACDTO;

/**
 * Trait STAC.
 */
trait STAC
{
    /**
     * STAC data.
     *
     * @var STACDTO
     */
    public STACDTO $stac;

    /**
     * Set STAC related data.
     *
     * @param Collection $data
     * @return $this
     */
    public function setStac(Collection $data): self
    {
        $this->stac = new STACDTO(data: $data);
        return $this;
    }
}
