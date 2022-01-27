<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Time\Minute;

/**
 * Class LeafMoisture.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class LeafMoisture extends AbstractClimateData
{
    /**
     * LeafMoisture constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Minute();
    }
}
