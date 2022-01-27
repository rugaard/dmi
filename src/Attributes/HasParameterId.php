<?php
declare(strict_types=1);

namespace Rugaard\DMI\Attributes;

/**
 * Trait HasParameterId.
 *
 * @package Rugaard\DMI\Attributes
 */
trait HasParameterId
{
    /**
     * Parameter ID attribute.
     *
     * @var string
     */
    protected string $parameterId;

    /**
     * Set parameter ID attribute.
     *
     * @param string $parameterId
     * @return $this
     */
    public function setParameterId(string $parameterId): self
    {
        $this->parameterId = $parameterId;
        return $this;
    }

    /**
     * Get parameter ID attribute.
     *
     * @return string
     */
    public function getParameterId(): string
    {
        return $this->parameterId;
    }
}
