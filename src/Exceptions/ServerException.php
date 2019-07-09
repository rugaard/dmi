<?php
declare(strict_types=1);

namespace Rugaard\DMI\Exceptions;

use GuzzleHttp\Exception\ServerException as GuzzleServerException;

/**
 * Class ServerException
 *
 * @package Rugaard\DMI\Exceptions
 */
class ServerException extends GuzzleServerException {}