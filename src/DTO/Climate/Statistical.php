<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Time\Day;

/**
 * Class Statistical.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Statistical extends AbstractClimateData
{
    /**
     * Statistical constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Day();
    }
}
