<?php

namespace Cloudoki;
use Exception;

/*
 * Quota Exceeded Exception Class
 *
 * Some quota limitation has been exceeded. Used in eg. the Limiter package.
 */

class QuotaExceededException extends Exception {}
