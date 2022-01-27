<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate\Snow;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Percentage;

/**
 * Class SnowCover.
 *
 * @package Rugaard\DMI\DTO\Climate\Snow
 */
class SnowCover extends AbstractClimateData
{
    /**
     * Snow constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Percentage();
    }
}
