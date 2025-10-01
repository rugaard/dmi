<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Centimeter.
 */
class Centimeter extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Centimeter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Centimeters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'cm';
}
