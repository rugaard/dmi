<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Contracts;

/**
 * Interface DTO
 *
 * @package Rugaard\OldDMI\Contracts
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
