<?php

/*
|--------------------------------------------------------------------------
| Application Error Handler - Laravel 4.2
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