<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Day.
 *
 * @package Rugaard\DMI\Unit\Time
 */
class Day extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Day';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Days';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'd';
}
