<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Pressure;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Kilopascal.
 *
 * @package Rugaard\DMI\Unit\Pressure
 */
class Kilopascal extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Kilopascal';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Kilopascals';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'kPa';
}
