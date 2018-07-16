<?php
declare( strict_types = 1 );

namespace App\Services\Config\lib\Exceptions;
use Throwable;


/**
 * Class ConfigException
 * @package App\Services\Config\lib\Exceptions
 */
class GetConfigException extends \RuntimeException
{
	/**
	 * Construct the exception. Note: The message is NOT binary safe.
	 * @link http://php.net/manual/en/exception.construct.php
	 * @param string $message [optional] The Exception message to throw.
	 * @param int $code [optional] The Exception code.
	 * @param Throwable $previous [optional] The previous throwable used for the exception chaining.
	 * @since 5.1.0
	 */
	public function __construct (string $message = '', int $code = 500, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}