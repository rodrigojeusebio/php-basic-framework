<?php

declare(strict_types=1);

namespace Libs;

use Exception;
use Generator;

final class File
{
    /**
     * Returns a generator with the lines of the provided file
     *
     * @return Generator<string>
     */
    public static function get_lines(string $file_path): Generator
    {
        if (! file_exists($file_path)) {
            throw new Exception("File does not exist ($file_path)");
        }

        /** @var resource $f */
        $f = fopen($file_path, 'r');
        try {
            while ($line = fgets($f)) {
                yield $line;
            }
        } finally {
            fclose($f);
        }
    }
}
