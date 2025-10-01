<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Meter.
 *
 * @package Rugaard\DMI\Unit\Length
 */
class Meter extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Meter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Meters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'm';
}
