<?php
declare(strict_types=1);

namespace Rugaard\OldDMI\Exceptions;

use GuzzleHttp\Exception\TransferException as GuzzleTransferException;

/**
 * Class RequestException
 *
 * @package Rugaard\OldDMI\Exceptions
 */
class RequestException extends GuzzleTransferException {}
