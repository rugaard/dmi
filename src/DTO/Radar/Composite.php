<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Radar;

use Rugaard\DMI\Abstracts\Radar;
use Rugaard\DMI\Enums\Radar\ScanType;

/**
 * Class Composite.
 */
class Composite extends Radar
{
    /**
     * Type of radar scan.
     *
     * @var ScanType
     */
    public ScanType $type;

    /**
     * Set radar scan type.
     *
     * @param string $type
     * @return $this
     */
    protected function setScanType(string $type): self
    {
        $this->type = ScanType::from(value: $type);
        return $this;
    }
}
