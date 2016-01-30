<?php

namespace Cloudoki;
use Exception;

/*
 * Invalid Environment Exception Class
 *
 * If an interaction is triggered outside the desired environment scope (eg. development or production), an InvalidEnvironment should be thrown to kill the process.
 */

class InvalidEnvironmentException extends Exception {}
