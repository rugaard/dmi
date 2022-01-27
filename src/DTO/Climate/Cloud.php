<?php

declare(strict_types=1);

namespace Rugaard\DMI\DTO\Climate;

use Rugaard\DMI\Abstracts\AbstractClimateData;
use Rugaard\DMI\Units\Percentage;

/**
 * Class Cloud.
 *
 * @package Rugaard\DMI\DTO\Climate
 */
class Cloud extends AbstractClimateData
{
    /**
     * Support method of determining
     * how cloud cover was measured.
     *
     * @var string|null
     */
    public ?string $method;

    /**
     * Cloud constructor.
     *
     * @param mixed ...$data
     */
    public function __construct(...$data)
    {
        parent::__construct($data);
        $this->unit = new Percentage();
    }
}
