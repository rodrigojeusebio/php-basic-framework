<?php

declare(strict_types=1);

namespace Core;

use Exception;
use Throwable;

final class ExceptionHandler
{
    /**
     * Handle the thrown exception
     */
    public static function handler(Throwable $exception): void
    {
        echo $exception->getMessage();
        exit;
    }
}

final class App_Exception extends Exception
{
    /**
     * Throw exception with the level for logging
     *
     * @param  'critical'|'error'|'warning'|'info'  $level
     * @param  null|string|array<string,mixed>  $extra
     */
    public function __construct(
        public string $level,
        string $message,
        public string|array|null $extra = null
    ) {
        parent::__construct($message, 0, null);
    }
}
