<?php

declare(strict_types=1);

namespace Core;

use Exception;
use Helpers\Arr;
use Throwable;

final class ExceptionHandler
{
    /**
     * Handle the thrown exception
     */
    public static function handler(Throwable $exception): void
    {
        $message = $exception->getMessage();
        $stack_trace = $exception->getTraceAsString();
        // $stack_trace = self::build_basic_trace($exception->getTrace());
        // $stack_trace = implode("\n", $stack_trace);

        if ($exception instanceof App_Exception) {
            $level = $exception->level;
            $extra = $exception->extra;
            Logger::log(
                $level,
                $message,
                $extra,
                $stack_trace
            );
        } else {
            $extra = null;
            $level = 'system';
        }

        Render::view('default_pages/ExceptionViewer', [
            'level' => $level,
            'message' => $message,
            'extra' => $extra,
            'stack_trace' => $stack_trace,
        ]);
    }

    // /**
    //  * @param array<array<string,string>> $trace
    //  * @return array<string>
    //  */
    // private static function build_basic_trace(array $trace): array
    // {
    //     $new_trace = [];

    //     foreach ($trace as $trace_step)
    //     {
    //         $new_trace_step = '';
    //         $file           = get_val($trace_step, 'file', '');
    //         $line           = get_val($trace_step, 'line', '');
    //         $function       = get_val($trace_step, 'function', '');
    //         $type           = get_val($trace_step, 'type', '');
    //         $class          = get_val($trace_step, 'class', '');
    //         // Args are crazy to manage
    //         // This can be an enum, a string, an array of arrays, i need to learn how to manage this
    //         $args       = Arr::implode(',', get_val($trace_step, 'args', []));
    //         $clean_args = [];

    //         if ($file)
    //         {
    //             $new_trace_step .= $file;
    //         }
    //         else
    //         {
    //             $new_trace_step .= '[internal function]';
    //         }

    //         $new_trace_step = $new_trace_step.':'.$line.' => '.$class.$type.$function;

    //         echo '<pre>';
    //         var_dump($args);

    //         $new_trace_step = $new_trace_step.'('.$args.')';

    //         $new_trace[] = $new_trace_step;
    //     }

    //     return $new_trace;
    // }
}

final class App_Exception extends Exception
{
    /** @var array<string, mixed>|array<mixed> */
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
