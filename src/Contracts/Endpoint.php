<?php
declare(strict_types=1);

namespace Rugaard\DMI\Contracts;

/**
 * Interface Endpoint
 *
 * @package Rugaard\DMI\Contracts
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