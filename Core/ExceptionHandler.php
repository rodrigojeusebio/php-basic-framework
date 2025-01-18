<?php

namespace Core;

final class ExceptionHandler
{
    /**
     * Handle the thrown exception  
     */
    public static function handler(\Throwable $exception): void
    {
        echo $exception->getMessage();
        die;
    }
}

class App_Exception extends \Exception
{
    /**
     * Throw exception with the level for logging
     * @param string{'critical','error','warning','info'} $level
     */
    public function __construct(
        public string $level,
        string $message,
        public string|array|null $extra = null
    ) {
        parent::__construct($message, 0, null);
    }
}