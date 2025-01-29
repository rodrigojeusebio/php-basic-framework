<?php
namespace Core;

class Preprocessor
{
    private string $filename;
    private string $new_contents;

    public function write_file(): string
    {
        $new_filename = $this->filename . '.safe.php';
        file_put_contents($new_filename, $this->new_contents);
        return $new_filename;
    }


    public function __construct(
        string $filename
    ) {
        $this->filename = $filename;
    }

    public function process(): string
    {
        $contents = (string) file_get_contents($this->filename);
        $this->new_contents = $this->viewToPhp($contents);
        return $this->write_file();
    }

    function viewToPhp(string $template): string
    {
        $patterns = [
            // Control structures
            '/@if\((.*?)\)/' => '<?php if ($1): ?>',
            '/@else/' => '<?php else: ?>',
            '/@endif/' => '<?php endif; ?>',

            '/@for\((.*?)\)/' => '<?php for ($1): ?>',
            '/@endfor/' => '<?php endfor; ?>',

            '/@foreach\(([^,]+),\s*([^,]+),\s*([^)]+)\)/' => '<?php foreach ($1 as $2 => $3): ?>',
            '/@foreach\(([^,]+),\s*([^)]+)\)/' => '<?php foreach ($1 as $2): ?>',
            '/@endforeach/' => '<?php endforeach; ?>',

            '/@auth/' => '<?php use Libs\Auth; if (Auth::check()): ?>',
            '/@guest/' => '<?php use Libs\Auth; if (Auth::guest()): ?>',
            '/@endauth|@endguest/' => '<?php endif; ?>',

            // Component system
            '/@component\(\s*[\'"](.+?)[\'"]\s*,\s*(\[.*?\])\s*\)/' =>
                '<?php extract($2); component($1)"; ?>',
            '/@component\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php components($1)"; ?>',
            '/@endcomponent/' => '',

            // Old input retrieval
            '/@old\(\s*[\'"](.+?)[\'"]\s*,\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?= htmlspecialchars(old("$1", "$2")) ?>',
            '/@old\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?= htmlspecialchars(old("$1")) ?>',

            // Error handling
            '/@errors\(\s*[\'"](.+?)[\'"]\s*\)/' =>
                '<?php foreach (errors("$1") as $error): ?>',
            '/@error/' => '<?= htmlspecialchars($error) ?>',
            '/@enderrors/' => '<?php endforeach; ?>',

            // Handle {{ $value }} escaping
            '/{{\s*(?!\!)(.*?)\s*}}/' => '<?= htmlspecialchars($1) ?>',

            // Handle {{ ! $value ! }} raw output
            '/{{\s*\!(.*?)\!\s*}}/' => '<?= $1 ?>',
        ];

        return preg_replace(array_keys($patterns), array_values($patterns), $template);
    }
}