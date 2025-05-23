<?php

declare(strict_types=1);

namespace Core;

final class ErrorHandler
{
    public static function handler(
        int $errno,
        string $errstr,
        ?string $errfile = null,
        ?int $errline = null,
    ): bool {
        throw new App_Exception('error', $errstr, ['errno' => $errno]);
    }
}
