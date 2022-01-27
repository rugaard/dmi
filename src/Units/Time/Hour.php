<?php
declare(strict_types=1);

namespace Rugaard\DMI\Units\Time;

use Rugaard\DMI\Abstracts\AbstractUnit;

/**
 * Class Hour.
 *
 * @package Rugaard\DMI\Unit\Time
 */
class Hour extends AbstractUnit
{
    /**
     * Name in singular form.
     *
     * @var string
     */
    protected string $singular = 'Hour';

    /**
     * Name in plural form.
     *
     * @var string
     */
    protected string $plural = 'Hours';

    /**
     * Abbreviation of unit name.
     *
     * @var string
     */
    protected string $abbreviation = 'hrs';
}
