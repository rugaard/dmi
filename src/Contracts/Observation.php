<?php
declare(strict_types=1);

namespace Rugaard\DMI\Contracts;

/**
 * Interface Observation
 *
 * @package Rugaard\DMI\Contracts
 */
interface Observation
{
    /**
     * Set ID.
     *
     * @param string $id
     * @return $this
     */
    public function setId(string $id): self;

    /**
     * Get ID.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set internal type ID.
     *
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self;

    /**
     * Get internal type ID.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Set description.
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): self;

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription(): string;

    /**
     * Set value.
     *
     * @param string|int|float $value
     * @return $this
     */
    public function setValue(string|int|float $value): self;

    /**
     * Get value.
     *
     * @return string|int|float
     */
    public function getValue(): string|int|float;
}
