<?php
declare(strict_types=1);

namespace Rugaard\DMI\Exceptions;

use GuzzleHttp\Exception\TransferException as GuzzleTransferException;

/**
 * Class RequestException
 *
 * @package Rugaard\DMI\Exceptions
 */
class RequestException extends GuzzleTransferException {}
