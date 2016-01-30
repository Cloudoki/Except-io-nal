<?php

namespace Cloudoki;
use Exception;

/*
 * Invalid User Exception Class
 *
 * A default authorisation error response.
 */

class InvalidUserException extends Exception
{
	public function __construct ($message = "", $code = 403, Exception $previous = null)
	{
		parent::__construct($message, (int) $code, $previous);
	}
}