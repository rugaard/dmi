<?php

declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Abstracts\Unit;

/**
 * Class MegajoulePerSquareMeter.
 */
class MegajoulePerSquareMeter extends Unit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    public string $name = 'Megajoule per square meter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    public string $namePlural = 'Megajoules per square meters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    public string $abbreviation = 'MJ/m²';
}
