<?php
declare(strict_types=1);

namespace Rugaard\DMI\Old\Exceptions;

use GuzzleHttp\Exception\TransferException as GuzzleTransferException;

/**
 * Class RequestException
 *
 * @package Rugaard\DMI\Old\Exceptions
 */
class RequestException extends GuzzleTransferException {}
