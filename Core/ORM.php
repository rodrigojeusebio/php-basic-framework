<?php

declare(strict_types=1);

namespace Core;

abstract class ORM
{
    /** @var array<string,mixed> */
    public array $attributes = [];

    public static string $table_name;

    final public function __construct() {}

    public function __get(string $attribute): mixed
    {
        if (isset($this->attributes[$attribute])) {
            return $this->attributes[$attribute];
        }

        return null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    final public static function find(int $id): static
    {
        $table_name = static::$table_name;
        $result = Database::query(
            "SELECT * FROM $table_name WHERE `id` = $id LIMIT 1"
        );

        $orm = new static();
        foreach ($result as $column => $value) {
            $orm->$column = $value;
        }

        return $orm;
    }

    /**
     * @param  array<string,mixed>  $values
     */
    final public static function create(array $values): void
    {
        $result = Database::query("PRAGMA table_info('users');");

        $table_columns = [];

        foreach ($result as $row) {
            $table_columns[] = $row['name'];
        }

        $orm_values = [];
        foreach ($values as $key => $value) {
            if (in_array($key, $table_columns)) {
                $orm_values[$key] = $value;
            }
        }

        $d = Database::get();
        $d->insert(static::$table_name, $orm_values);
    }
}
