<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Temperature;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Celsius.
 */
class Celsius extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Celsius';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Celsius';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = '°C';
}
