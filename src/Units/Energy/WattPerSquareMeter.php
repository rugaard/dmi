<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class WattPerSquareMeter.
 *
 * @package Rugaard\DMI\Unit\Energy
 */
class WattPerSquareMeter extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Watt per square meter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Watts per square meters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'W/m²';
}
