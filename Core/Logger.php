<?php

namespace Core;
use Core\Config;
use Libs\Singleton;
use Libs\File;


final class Logger extends Singleton
{
    /** @var array<string> */
    private array $logs = [];

    /**
     * @param string|array<string,string> $extra
     */
    public static function log(string $level, string $message, string|array $extra, string $stack_trace): void
    {
        $now                           = date('Y-m-d G:i:s');
        $level                         = strtoupper($level);
        $extra                         = json_encode($extra);
        static::get_instance()->logs[] = mb_convert_encoding("$now | $level | $message | $extra | $stack_trace\n", 'ASCII');

    }

    public static function flush(): void
    {
        $log_file = get_base_path().'Storage/basic.log';

        File::write_lines($log_file, self::get_instance()->logs);
    }

    public function __destruct()
    {
        self::get_instance()::flush();
    }

}