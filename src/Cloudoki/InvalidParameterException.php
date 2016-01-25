<?php

namespace Cloudoki;

/*
 * Invalid Parameter Exception Class
 *
 * An array with invalid parameters can be provided for good measure.
 * Probably the most common custom Exception.
 */

class InvalidParameterException extends Exception
{

    private $_errors;

    public function __construct ($message = "", $errors = ['Invalid parameters'], $code = 400, Exception $previous = null)
    {
        parent::__construct($message, (int) $code, $previous);

        $this->_errors = [$message, $errors];
    }

    public function getFullResponse () { return $this->_errors; }

    public function getErrors () { return $this->_errors[1]; }

}