<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Exceptions;

use GuzzleHttp\Exception\ServerException as GuzzleServerException;

/**
 * Class ServerException
 *
 * @package Rugaard\OldDMI\Exceptions
 */
class ServerException extends GuzzleServerException {}
