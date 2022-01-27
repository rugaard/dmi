<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Exceptions;

use GuzzleHttp\Exception\ClientException as GuzzleClientException;

/**
 * Class ClientException
 *
 * @package Rugaard\OldDMI\Exceptions
 */
class ClientException extends GuzzleClientException {}
