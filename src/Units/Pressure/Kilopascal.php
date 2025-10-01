<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Pressure;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Kilopascal.
 */
class Kilopascal extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Kilopascal';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Kilopascals';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'kPa';
}
