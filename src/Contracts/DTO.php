<?php
declare(strict_types=1);

namespace Rugaard\DMI\Contracts;

/**
 * Interface DTO
 *
 * @package Rugaard\DMI\Contracts
 */
interface DTO
{
    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    public function parse(array $data) : void;
}