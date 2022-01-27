<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Minute.
 *
 * @package Rugaard\DMI\Unit\Time
 */
class Minute extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Minute';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Minutes';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'min';
}
