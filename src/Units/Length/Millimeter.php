<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class Millimeter.
 */
class Millimeter extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Millimeter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Millimeters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'mm';
}
