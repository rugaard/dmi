<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Centimeter.
 *
 * @package Rugaard\DMI\Unit\Length
 */
class Centimeter extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Centimeter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Centimeters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'cm';
}
