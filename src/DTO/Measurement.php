<?php
declare(strict_types=1);

namespace Rugaard\DMI\DTO;

use Rugaard\DMI\Contracts\Observation;

/**
 * Class Measurement.
 *
 * @abstract
 * @package Rugaard\DMI\DTO
 */
abstract class Measurement extends DTO implements Observation
{
    /**
     * Unique ID.
     *
     * @var string|null
     */
    protected ?string $id;

    /**
     * Internal type ID.
     *
     * @var string
     */
    protected string $type;

    /**
     * Description of observation.
     *
     * @var string
     */
    protected string $description;

    /**
     * Temperature value.
     *
     * @var string|int|float
     */
    protected string|int|float $value;

    /**
     * Parse data.
     *
     * @param array $data
     * @return void
     */
    public function parse(array $data): void
    {
        $this->setId($data['id']);
    }

    /**
     * Set unique ID.
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Get unique ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set internal type ID.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Get internal type ID.
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * Set description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set value.
     *
     * @param string|int|float $value
     * @return $this
     */
    public function setValue(string|int|float $value): self
    {
        $this->value = $value;
        return $this;
    }

    /**
     * Get value.
     *
     * @return string|int|float
     */
    public function getValue(): string|int|float
    {
        return $this->value;
    }
}
