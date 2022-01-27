<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\DTO;

use Rugaard\DMI\Old\Contracts\DTO;

/**
 * Class AbstractDTO
 *
 * @package Rugaard\DMI\Old\DTO
 */
abstract class AbstractDTO implements DTO
{
    /**
     * AbstractDTO constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        if (!empty($data)) {
            $this->parse($data);
        }
    }

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    abstract public function parse(array $data) : void;

    /**
     * Return DTO as an array.
     *
     * @return array
     */
    public function toArray() : array
    {
        // Get all variables in class.
        $variables = get_object_vars($this);

        // Container
        $container = [];

        // Loop through each value and look for it's getter method.
        // If it doesn't exist, we'll ignore the variable.
        foreach ($variables as $variableName => $variableValue) {
            // Get value of variable.
            $value = $this->{'get' . ucfirst($variableName)}() ?? null;

            // Add value to container.
            $container[$variableName] = ($value instanceof self) ? $value->toArray() : $value;
        }

        return $container;
    }
}
