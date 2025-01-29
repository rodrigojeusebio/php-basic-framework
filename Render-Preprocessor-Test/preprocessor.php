<?php

// walk the file

// Structure, the file can be an array of lines
// We will evaluate one line at the time
// For now will not check for syntatic errors

// If I find the values @ or {{}}
// Check what are the following chars
// If @directive
// will expand it into the matching statement
// If {{}}
// will place the htmlspecialchars

class Preprocessor
{
    private string $filename;

    /** @var Generator<string> */
    private Generator $lines;

    /** @var array<string> */
    private array $newlines;

    /**
     * Returns a generator with the lines of the provided file
     *
     * @return Generator<string>
     */
    public static function get_lines(string $file_path): Generator
    {
        if (!file_exists($file_path)) {
            throw new Exception("File does not exist ($file_path)");
        }

        /** @var resource $f */
        $f = fopen($file_path, 'r');
        try {
            while ($line = fgets($f)) {
                yield trim($line);
            }
        } finally {
            fclose($f);
        }
    }

    public function write_file()
    {
        file_put_contents($this->filename . '.html.php', $this->newlines);
    }


    public function __construct(
        string $filename
    ) {
        $this->filename = $filename;
        $this->lines = self::get_lines($filename);
    }

    public function process()
    {
        foreach ($this->lines as $line) {
            $this->process_line($line);
        }

        $this->write_file();
    }

    public function process_line(string $line)
    {
        if (str_contains($line, '@') || str_contains($line, '{{')) {
            $line = $this->convert_line($line);
        }

        $this->newlines[] = $line;
    }

    public function convert_line(string $line): string
    {

    }

}

$pp = new Preprocessor('test.html.php');
$pp->process();
