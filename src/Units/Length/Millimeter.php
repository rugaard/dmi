<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Length;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Millimeter.
 *
 * @package Rugaard\DMI\Unit\Length
 */
class Millimeter extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Millimeter';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Millimeters';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'mm';
}
