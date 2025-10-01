<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Pressure;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Hectopascal.
 */
class Hectopascal extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Hectopascal';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Hectopascals';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'hPa';
}
