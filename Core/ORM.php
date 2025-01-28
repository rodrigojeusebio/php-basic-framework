<?php

declare(strict_types=1);

namespace Core;

use Helpers\Arr;

/**
 * @property-read int $id
 */
abstract class ORM
{
    /** @var array<string,mixed> */
    public array $attributes;

    public static string $table_name;

    public Database $database;

    final public function __construct()
    {
        $this->attributes = [];
        $this->database = Database::get();
    }

    public function __get(string $attribute): mixed
    {
        return get_val($this->attributes, $attribute, null);
    }

    public function __set(string $name, mixed $value): void
    {
        $this->attributes[$name] = $value;
    }

    final public function __call(string $method, mixed $args): mixed
    {
        if (method_exists(Database::class, $method)) {
            $this->database->$method(...$args);

            return $this;
        }

        throw new App_Exception('error', 'Method does not exist', [
            'class' => self::class,
            'method' => $method,
        ]);
    }

    final public static function __callStatic(string $method, mixed $args): mixed
    {
        if (method_exists(Database::class, $method)) {
            $orm = new static();
            $orm->database->$method(...$args);

            return $orm;
        }

        throw new App_Exception('error', 'Method does not exist', [
            'class' => self::class,
            'method' => $method,
        ]);
    }

    /**
     * @param  array<string,string|int>  $values
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

    final public static function find(?int $id = null, bool $required = false): static
    {
        $orm = new static;
        if ($id) {
            $result = $orm->database
                ->from(static::$table_name)
                ->where('id', '=', $id)
                ->find();
        } else {
            $result = $orm->database
                ->from(static::$table_name)
                ->find();
        }

        $result_row = Arr::first_value($result);

        if (is_array($result_row)) {
            $orm = new static();

            foreach ($result_row as $column => $value) {
                $orm->$column = $value;
            }
        } elseif ($required) {
            throw new App_Exception('error', 'You do not have access to this resource or it does not exist', ['table_name' => static::$table_name, 'id' => $id]);
        }

        return $orm;
    }

    /**
     * @return static[]
     */
    final public static function all(): array
    {
        $orm = new static;
        $table_name = static::$table_name;

        $result = $orm->database
            ->from($table_name)
            ->find_all();

        $array_all = [];

        foreach ($result as $result_row) {

            $orm = new static();

            foreach ($result_row as $column => $value) {
                $orm->$column = $value;
            }

            $array_all[] = $orm;
        }

        return $array_all;
    }

    /**
     * @param  array<string,string|int>  $values
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

        $this->database = Database::get();
        $this->database->update($table_name, $orm_values, $this->id);
    }

    final public function delete(): void
    {
        $this->database->delete(static::$table_name, $this->id);
    }

    final public function loaded(): bool
    {
        return isset($this->id);
    }
}
