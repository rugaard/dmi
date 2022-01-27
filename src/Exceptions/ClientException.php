<?php
declare(strict_types=1);

namespace Rugaard\DMI\Exceptions;

use GuzzleHttp\Exception\ClientException as GuzzleClientException;

/**
 * Class ClientException
 *
 * @package Rugaard\DMI\Exceptions
 */
class ClientException extends GuzzleClientException {}
