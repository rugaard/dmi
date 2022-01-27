<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Energy;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Kiloampere.
 *
 * @package Rugaard\DMI\Unit\Energy
 */
class Kiloampere extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Kiloampere';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Kiloamperes';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'kA';
}
