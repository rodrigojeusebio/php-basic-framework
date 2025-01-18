<?php

namespace Libs;

class File
{
    /**
     * Returns a generator with the lines of the provided file
     */
    public static function get_lines(string $file_path): \Generator
    {
        if (! file_exists($file_path))
        {
            throw new \Exception("File does not exist ($file_path)");
        }

        $f = fopen($file_path, 'r');
        try
        {
            while ($line = fgets($f))
            {
                yield $line;
            }
        } finally
        {
            fclose($f);
        }
    }
}