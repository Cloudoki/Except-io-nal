<?php

namespace Cloudoki;
use Exception;

/*
 * Database Exception Class
 *
 * We use the DatabaseException to define unexpected database responses and time-outs on connections.
 */

class DatabaseException extends Exception {}
