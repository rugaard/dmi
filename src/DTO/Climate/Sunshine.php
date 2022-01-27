<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Time\Hour;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class Sunshine.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Sunshine extends AbstractClimateData
{
    /**
     * Sunshine constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = $this->timeResolution === 'hour' ? new Minute() : new Hour();
    }
}
