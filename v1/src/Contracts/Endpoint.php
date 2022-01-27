<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Contracts;

/**
 * Interface Endpoint
 *
 * @package Rugaard\DMI\Old\Contracts
 */
interface Endpoint
{
    /**
     * Parse data received from endpoint.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void;
}
