<?php

declare(strict_types=1);

namespace Rugaard\DMI\Support\Attributes;

/**
 * Trait ActiveStatus.
 */
trait ActiveStatus
{
    /**
     * Whether active or inactive.
     *
     * @var bool
     */
    public bool $isActive;

    /**
     * Set active status.
     *
     * @param string $status
     * @return $this
     */
    protected function setStatus(string $status): self
    {
        $this->isActive = $status === 'Active';
        return $this;
    }
}
