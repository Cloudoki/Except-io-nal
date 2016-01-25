<?php

/*
 *	Exception Classes
 */

if (!class_exists ('DatabaseException'))
{
	class DatabaseException extends Exception {}
}

if (!class_exists ('InvalidEnvironmentException'))
{
	class InvalidEnvironmentException extends Exception {}
}

if (!class_exists ('MissingParameterException'))
{
	class MissingParameterException extends Exception {}
}

if ( ! class_exists ('InvalidParameterException'))
{
    class InvalidParameterException extends Exception
    {

        private $_errors;

        public function __construct ($message = "", $errors = array('Invalid parameters'), $code = 400, Exception $previous = null)
        {
            parent::__construct($message, (int) $code, $previous);

            $this->_errors = [$message, $errors];
        }

        public function getFullResponse () { return $this->_errors; }

        public function getErrors () { return $this->_errors[1]; }

    }
}

if (!class_exists ('IncompleteModelException'))
{
	class IncompleteModelException extends Exception {}
}

if (!class_exists ('MissingSchemaException'))
{
	class MissingSchemaException extends Exception {}
}

if (!class_exists ('QuotaExceededException'))
{
	class QuotaExceededException extends Exception {}
}

if (!class_exists ('InvalidUserException'))
{
	class InvalidUserException extends Exception
	{
		public function __construct ($message = "", $code = 403, Exception $previous = null)
		{
			parent::__construct($message, (int) $code, $previous);
		}
	}
}

if (!class_exists ('WorkerException'))
{
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
}


/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code, $fromConsole)
{
	
	# The error code
	$code = $exception->getCode()?: ($code?: 403);
	
	# Catch 400's
	if (in_array($code, [400, 405]))
		
		return Response::json ($exception->getMessage()?: "Malformed method or request syntax", 400);
		
	# Catch 403's
	if (in_array($code, [401, 403]))
		
		return Response::json ("No valid authorization provided", 403);
		
	# Catch 404's
	if ($code == 404)
		
		return Response::json (null, 404);


	# More Serious errors
	# write to log
	Log::error($exception);

	$response = array('code' => $code);

	if (Config::get ('app.debug'))
	{
		$response['error'] = $exception->__toString();
		$response['message'] = method_exists($exception, 'getFullResponse')?
			
			$exception->getFullResponse (): $exception->getMessage();
	}
	else
	
		$response['message'] = $exception->getMessage();

	return Response::json($response, $code);
});