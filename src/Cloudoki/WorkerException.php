<?php

namespace Cloudoki;
use Exception;

/*
 * Worker Exception Class
 *
 * The API should define errors bubbled up from the Worker response as a *WorkerException* for logging purposes. 
 */

class WorkerException extends Exception
{
	public function __construct ($payload)
	{
		$error = json_decode ($payload);
		$this->_errors = $payload;

		parent::__construct($error->message, (int) $error->code);
	}

	public function getFullResponse () { return $this->_errors; }
}