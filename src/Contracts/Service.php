<?php
declare(strict_types=1);

namespace Rugaard\DMI\Contracts;

/**
 * Interface Service.
 *
 * @package Rugaard\DMI\Contracts
 */
interface Service
{
    /**
     * Get service name.
     *
     * @return string
     */
    public function getServiceName(): string;

    /**
     * Get service version.
     *
     * @return string
     */
    public function getServiceVersion(): string;
}
