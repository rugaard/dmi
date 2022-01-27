<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Endpoints;

use Rugaard\DMI\Old\Contracts\Endpoint;
use Tightenco\Collect\Support\Collection;

/**
 * Class AbstractEndpoint
 *
 * @package Rugaard\DMI\Old\Endpoints
 */
abstract class AbstractEndpoint implements Endpoint
{
    /**
     * Parsed data.
     *
     * @var array
     */
    protected $data = [];

    /**
     * AbstractEndpoint constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->parse($data);
    }

    /**
     * Parse data.
     *
     * @param  array $data
     * @return void
     */
    abstract public function parse(array $data) : void;

    /**
     * Set parsed data.
     *
     * @param mixed $data
     * @return $this
     */
    public function setData($data) : self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get parsed data.
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }
}
