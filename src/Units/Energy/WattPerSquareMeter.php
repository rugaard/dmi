<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class WattPerSquareMeter.
 */
class WattPerSquareMeter extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Watt per square meter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Watts per square meters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'W/m²';
}
