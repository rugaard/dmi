<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate\Wind;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Bearing;

/**
 * Class WindDirection.
 *
 * @package Rugaard\DMI\DTO\Climate\Wind
 */
class WindDirection extends AbstractClimateData
{
    /**
     * WindDirection constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Bearing();
    }
}
