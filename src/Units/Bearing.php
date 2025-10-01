<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Bearing.
 */
class Bearing extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Degree';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Degrees';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = '°';
}
