<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Rugaard\DMI\Contracts\DTO as DTOContract;

/**
 * Class AbstractDTO.
 *
 * @abstract
 * @package Rugaard\DMI
 */
abstract class DTO implements DTOContract
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
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        foreach ($data as $key => $value) {
            if (!method_exists($this, 'set'. ucfirst($key))) {
                continue;
            }

            $this->{'set'. ucfirst($key)}($value);
        }
    }

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
            $value = $this->{'get' . ucfirst($variableName)}();

            // Add value to container.
            $container[$variableName] = ($value instanceof self) ? $value->toArray() : $value;
        }

        return $container;
    }
}
