<?php

declare(strict_types=1);

namespace Core;

use Exception;
use Core\Logger;
use Helpers\Arr;
use Throwable;

final class ExceptionHandler
{
    /**
     * Handle the thrown exception
     */
    public static function handler(Throwable $exception): void
    {
        if ($exception instanceof App_Exception)
        {
            Logger::log(
                $exception->level,
                $exception->getMessage(),
                $exception->extra,
                $exception->getTraceAsString()
            );

            Render::view('default_pages/ExceptionViewer', [
                'level'       => $exception->level,
                'message'     => $exception->getMessage(),
                'extra'       => $exception->extra,
                'stack_trace' => $exception->getTraceAsString(),
            ]);

        }
    }
}

final class App_Exception extends Exception
{
    /** @var array<string, mixed> */
    public array $extra;

    /**
     * Throw exception with the level for logging
     *
     * @param  'critical'|'error'|'warning'|'info'  $level
     * @param  array<string,mixed>  $extra
     */
    public function __construct(
        public string $level,
        string $message,
        string|array $extra = []
    ) {
        $this->extra = Arr::wrap($extra);
        parent::__construct($message, 0, null);
    }
}
