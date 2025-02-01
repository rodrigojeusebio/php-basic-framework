<?php

declare(strict_types=1);

namespace Core;

use Libs\Singleton;
use RuntimeException;

final class Render extends Singleton
{
    /**
     * Variables that will always be set on the view
     *
     * @var array<string,mixed>
     */
    private static array $global_variables = ['errors' => [], 'attributes' => []];

    private static bool $auth_imported = false; // Track if Auth has been imported

    /**
     * @param  array<string,mixed>  $variables
     */
    public static function view(string $path, array $variables = []): void
    {
        extract($variables);
        $template_path = $path;
        $default_layout = 'layouts/default';
        self::page(
            $default_layout,
            array_merge(['__view' => $template_path], $variables)
        );
    }

    /**
     * @param  array<string,mixed>  $variables
     */
    public static function page(string $path, array $variables = []): void
    {
        $render = self::get_instance();
        extract(self::$global_variables);
        extract($variables);
        $template_path = self::get_view_path($path);
        $compile_view = self::compile($template_path);
        include $compile_view;
    }

    private static function get_view_path(string $path): string
    {
        return get_app_path().'Resources/Views/'.$path.'.basic.php';
    }

    /**
     * This method compiles the template by processing each line.
     * (For simplicity we split on newlines; a more robust parser would work on the entire file.)
     */
    private static function compile(string $template_path): string
    {
        $contents = file_get_contents($template_path);
        if ($contents === false) {
            throw new RuntimeException("Cannot read template file: $template_path");
        }
        $contents_file = explode("\n", $contents);
        $processed_lines = [];

        foreach ($contents_file as $line) {
            $processed_lines[] = self::process_line($line);
        }

        // Save the compiled file to a temporary file (or a cache) and return its path.
        // Here we simply save to the same directory with a .compiled.php extension.
        $compiled_path = $template_path.'.compiled.php';
        file_put_contents($compiled_path, implode("\n", $processed_lines));

        return $compiled_path;
    }

    /**
     * Process a single line of the template file.
     * This method manually parses directives and converts them to PHP.
     */
    private static function process_line(string $line): string
    {
        $trimmed = trim($line);

        // === Handle Block Directives with Parentheses (manual parsing) ===

        $php_open = '<? ';
        $php_close = ' ?>';
        // @if(...) --> $php_open if(...): $php_close
        if (mb_strpos($trimmed, '@if(') === 0) {
            $condition = self::extract_between_parentheses($trimmed);
            if ($condition !== null) {
                return "$php_open if({$condition}): $php_close";
            }
        }

        // @foreach(...) --> $php_open foreach(...): $php_close
        if (mb_strpos($trimmed, '@foreach(') === 0) {
            $expression = self::extract_between_parentheses($trimmed);
            if ($expression !== null) {
                return "$php_open foreach({$expression}): $php_close";
            }
        }

        // @component('path/to/component')
        if (mb_strpos($trimmed, '@component(') === 0) {
            $component_view = self::extract_between_parentheses($trimmed);

            if ($component_view !== null) {
                $component_view = trim($component_view);

                // Check if it's a variable ($var) or a string ('view.name')
                if (preg_match('/^\$[\w]+/', $component_view)) {
                    // It's a variable -> Resolve inside PHP dynamically
                    return "$php_open \$__compiled_view = self::compile(self::get_view_path({$component_view})); include \$__compiled_view $php_close";
                }
                // It's a string -> Resolve at compile time
                $component_view = trim($component_view, " '\"");
                $compiled_component = self::compile(self::get_view_path($component_view));

                return "$php_open include '{$compiled_component}'; $php_close";

            }
        }
        // @method('PUT') --> <input type="hidden" name="_method" value="PUT">
        if (mb_strpos($trimmed, '@method(') === 0) {
            $method = self::extract_between_parentheses($trimmed);
            if ($method !== null) {
                $method = trim($method, " '\"");

                return "<input type=\"hidden\" name=\"_method\" value=\"{$method}\">";
            }
        }
        // @old('field') --> $php_open echo htmlspecialchars($_POST['field'] ?? ''); $php_close

        if (str_contains($trimmed, '@old(')) {
            // We allow @old to appear inline.
            while (($start = mb_strpos($line, '@old(')) !== false) {
                $extracted = self::extract_between_parentheses(mb_substr($line, $start));
                if ($extracted === null) {
                    break;
                }
                $replacement = "$php_open echo htmlspecialchars(old($extracted) ?? ''); $php_close";
                // Replace the first occurrence
                $line = substr_replace($line, $replacement, $start, mb_strlen("@old({$extracted})"));
            }

            return $line;
        }

        // @error('field') --> $php_open if(isset($errors['field'])): $php_close
        if (mb_strpos($trimmed, '@errors(') === 0) {
            $field = self::extract_between_parentheses($trimmed);
            if ($field !== null) {
                $field = trim($field, " '\"");

                return "$php_open foreach(errors('{$field}') as \$error): $php_close";
            }
        }
        // @error --> $php_open $error $php_close
        elseif (mb_strpos($trimmed, '@error') !== false) {
            // We allow @old to appear inline.
            while (($start = mb_strpos($line, '@error')) !== false) {
                $replacement = "$php_open echo htmlspecialchars(\$error); $php_close";
                // Replace the first occurrence
                $line = substr_replace($line, $replacement, $start, mb_strlen('@error'));
            }

            return $line;
        }

        // === Handle Single-line Directives (no parentheses) ===

        // @endif, @endforeach, @endauth, @endguest, @enderror
        $end_directives = [
            '@endif' => "$php_open endif; $php_close",
            '@endforeach' => "$php_open endforeach; $php_close",
            '@endauth' => "$php_open endif; $php_close",
            '@endguest' => "$php_open endif; $php_close",
            '@enderrors' => "$php_open endforeach; $php_close",
        ];
        if (isset($end_directives[$trimmed])) {
            return $end_directives[$trimmed];
        }

        // @else --> $php_open else: $php_close
        if ($trimmed === '@else') {
            return "$php_open else: $php_close";
        }
        // Ensure `use Libs\Auth;` is added only once at the top
        if (($trimmed === '@auth' || $trimmed === '@guest') && ! self::$auth_imported) {
            self::$auth_imported = true;

            return "$php_open use Libs\Auth; $php_close\n".self::process_line($trimmed);
        }
        // @auth --> $php_open if(Auth::check()): $php_close
        if ($trimmed === '@auth') {
            return "$php_open if(Auth::check()): $php_close";
        }

        // @guest --> $php_open if(Auth::guest()): $php_close
        if ($trimmed === '@guest') {
            return "$php_open if(Auth::guest()): $php_close";
        }

        // === Handle Inline Variable Echo with Curly Braces ===

        // Replace all occurrences of {{ expression }} with: $php_open echo htmlspecialchars(expression); $php_close
        // We use a loop in case there are multiple per line.
        while (($start = mb_strpos($line, '{{')) !== false) {
            $end = mb_strpos($line, '}}', $start);
            if ($end === false) {
                // No closing braces, abort processing this line.
                break;
            }
            // Extract the content inside the braces.
            $expression = trim(mb_substr($line, $start + 2, $end - $start - 2));
            $replacement = "$php_open echo htmlspecialchars({$expression}); $php_close";
            $line = substr_replace($line, $replacement, $start, ($end + 2) - $start);
        }

        // If nothing matched, return the line unchanged.
        return $line;
    }

    /**
     * Helper method to extract the string between the first '(' and the last ')'
     * in a directive string.
     *
     * For example, given: "@if(Auth::check())" it returns "Auth::check()"
     *
     * @param  string  $directive  The full directive line.
     * @return string|null Returns the extracted string or null if not found.
     */
    private static function extract_between_parentheses(string $directive): ?string
    {
        $start = mb_strpos($directive, '(');
        $end = mb_strrpos($directive, ')');
        if ($start === false || $end === false || $end <= $start) {
            return null;
        }

        return mb_substr($directive, $start + 1, $end - $start - 1);
    }
}
