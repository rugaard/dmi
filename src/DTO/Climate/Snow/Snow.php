<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate\Snow;

use DateTime;
use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Length\Centimeter;

/**
 * Class Snow.
 *
 * @package Rugaard\DMI\DTO\Climate\Snow
 */
class Snow extends AbstractClimateData
{
    /**
     * Supports values which in come cases,
     * comes with an associated date.
     *
     * @var \DateTime|null
     */
    public ?DateTime $date;

    /**
     * Snow constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Centimeter();
    }
}
