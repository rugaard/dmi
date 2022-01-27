<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate\Wind;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Speed\MetersPerSecond;

/**
 * Class Wind.
 *
 * @package Rugaard\DMI\DTO\Climate\Wind
 */
class Wind extends AbstractClimateData
{
    /**
     * Wind constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new MetersPerSecond();
    }
}
