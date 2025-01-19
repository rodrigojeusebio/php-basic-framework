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
    public static function log(string $level, string $message, string|array $extra): void
    {
        $now                           = date('Y-m-d h:m');
        $level                         = ucwords($level);
        $extra                         = json_encode($extra);
        static::get_instance()->logs[] = "$now | $level | $message | $extra\n";

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