<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Contracts;

/**
 * Interface DTO
 *
 * @package Rugaard\DMI\Old\Contracts
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
