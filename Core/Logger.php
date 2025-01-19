<?php

namespace Core;

use Libs\File;
use Libs\Singleton;

final class Logger extends Singleton
{
    /** @var array<string> */
    private array $logs = [];

    public function __destruct()
    {
        self::get_instance()::flush();
    }

    /**
     * @param  string|array<string,mixed>|array<mixed>  $extra
     */
    public static function log(string $level, string $message, string|array $extra, string $stack_trace): void
    {
        $now = date('Y-m-d G:i:s');
        $level = mb_strtoupper($level);
        $extra = json_encode($extra);
        self::get_instance()->logs[] = mb_convert_encoding("$now | $level | $message | $extra | $stack_trace\n", 'ASCII');

    }

    public static function flush(): void
    {
        $log_file = get_base_path().'Storage/basic.log';

        File::write_lines($log_file, self::get_instance()->logs);
    }
}
