<?php

namespace Core;

use Closure;
use Helpers\Arr;

class Validation
{
    /**
     * @var array<Rule>
     */
    public array $rules = [];

    /**
     * @var array<Callback>
     */
    public array $callbacks = [];

    /**
     * @var array<string,array<string>>
     */
    public array $errors = [];

    /**
     * @var array<string>
     */
    public array $fields = [];

    /**
     * @param  array<string,mixed>  $values
     */
    public function __construct(public array $values) {}

    public function __get(string $field): mixed
    {
        return get_val($this->values, $field, null);
    }

    public function validate(): bool
    {
        foreach ($this->rules as $rule) {
            $rule->evaluate($this, $this->values[$rule->field]);
        }

        foreach ($this->callbacks as $callback) {
            $callback->evaluate($this);
        }

        if (empty($this->errors)) {
            // Array flip to make the array with the same keys as values
            $this->values = array_intersect_key($this->values, array_flip($this->fields));
        }

        return empty($this->errors);
    }

    /**
     * @param  string|array<string>  $rules
     */
    public function add_rule(string $field, string|array $rules, ?string $custom_message = null): static
    {
        $this->fields[] = $field;

        foreach (Arr::wrap($rules) as $rule) {
            $this->rules[] = new Rule($field, $rule, $custom_message);
        }

        return $this;
    }

    /**
     * @param  string|array{string,string}|Closure  $callback
     */
    public function add_callback(string $field, string|array|Closure $callback): static
    {
        $this->fields[] = $field;

        $this->callbacks[] = new Callback($field, $callback);

        return $this;
    }

    public function add_error(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    /**
     * @param  string|array<string>  $field
     */
    public function has_errors(string|array $field): bool
    {
        foreach (Arr::wrap($field) as $field) {
            if (in_array($field, array_keys($this->errors))) {
                return true;
            }
        }

        return false;
    }
}

class Rule
{
    /**
     * @var array<string,string>
     */
    public static array $validation_messages = [
        'required' => 'Value is required',
        'string' => 'Value should be alpha numeric',
        'numeric' => 'Value should be numeric',
        'int' => 'Value should be an integer',
        'email' => 'Provide a valid email',
    ];

    public function __construct(
        public string $field,
        public string $rule,
        public ?string $custom_message = null,
    ) {}

    public function evaluate(Validation $validation, mixed $value): void
    {
        $validate = match ($this->rule) {
            'required' => $value !== '',
            'string' => is_string($value),
            'numeric' => is_numeric($value),
            'int' => is_int($value),
            'email' => is_string($value),
            default => throw new App_Exception('error', 'Validation rule is not supported', ['validation' => $this->rule])
        };

        if (! $validate) {
            $validation->add_error(
                $this->field,
                $this->custom_message ?: self::$validation_messages[$this->rule],
            );
        }
    }
}

class Callback
{
    /**
     * @param  string|array{string,string}|Closure  $callable
     */
    public function __construct(
        public string $field,
        public string|array|Closure $callable,
    ) {}

    public function evaluate(Validation $validation): void
    {
        if (is_callable($this->callable)) {
            if (is_array($this->callable)) {
                call_user_func_array($this->callable, [$validation, $this->field]);
            } elseif (is_string($this->callable)) {
                call_user_func($this->callable, $validation, $this->field);
            }
        }

        if ($this->callable instanceof Closure) {
            $callable = $this->callable;
            $callable($validation, $this->field);
        }
    }
}
