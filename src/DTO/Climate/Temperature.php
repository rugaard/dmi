<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use DateTime;
use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Temperature\Celsius;

/**
 * Class Temperature.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Temperature extends AbstractClimateData
{
    /**
     * Supports values which in come cases,
     * comes with an associated date.
     *
     * @var \DateTime|null
     */
    public ?DateTime $date;

    /**
     * Temperature constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Celsius();
    }
}
