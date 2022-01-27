<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class MegajoulePerSquareMeter.
 *
 * @package Rugaard\DMI\Unit\Energy
 */
class MegajoulePerSquareMeter extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Megajoule per square meter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Megajoules per square meters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'MJ/m²';
}
