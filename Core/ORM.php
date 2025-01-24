<?php

declare(strict_types=1);

namespace Core;

use Helpers\Arr;

abstract class ORM
{
    /** @var array<string,mixed> */
    public array $attributes;

    public int $id;

    public static string $table_name;

    final public function __construct()
    {
        $this->attributes = [];
    }

    public function __get(string $attribute): mixed
    {
        return get_val($this->attributes, $attribute, null);
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

        $result_row = Arr::first_value($result);

        if (is_array($result_row)) {
            $orm = new static();

            foreach ($result_row as $column => $value) {
                $orm->$column = $value;
            }
        } else {
            throw new App_Exception('error', 'You do not have access to this resource or it does not exist', ['table_name' => static::$table_name, 'id' => $id]);
        }

        return $orm;
    }

    /**
     * @param  array<string,mixed>  $values
     */
    final public static function create(array $values): static
    {
        $table_name = static::$table_name;
        $result = Database::query("PRAGMA table_info('$table_name');");

        $table_columns = [];

        foreach ($result as $row) {
            $table_columns[] = $row['name'];
        }

        /** @var array<string,int|string> $orm_values */
        $orm_values = [];

        foreach ($values as $key => $value) {
            if (in_array($key, $table_columns)) {
                $orm_values[$key] = $value;
            }
        }

        $d = Database::get();
        $d->insert($table_name, $orm_values);

        $id = $d->get_last_id();

        return static::find($id);
    }

    /**
     * @param  array<string,mixed>  $values
     */
    final public function update(array $values): void
    {
        $table_name = static::$table_name;
        $result = Database::query("PRAGMA table_info('$table_name');");

        $table_columns = [];

        foreach ($result as $row) {
            $table_columns[] = $row['name'];
        }

        /** @var array<string,int|string> $orm_values */
        $orm_values = [];

        foreach ($values as $key => $value) {
            if (in_array($key, $table_columns)) {
                $orm_values[$key] = $value;
            }
        }

        $d = Database::get();
        $d->update($table_name, $orm_values, $this->id);
    }
}
