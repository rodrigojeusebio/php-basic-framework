<?php

namespace Core;


class ORM
{
    public array $attributes = [];
    public static string $table_name;


    public function __get($attribute)
    {
        if (isset($this->attributes[$attribute]))
        {
            return $this->attributes[$attribute];
        }
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public static function find(int $id): static
    {
        $table_name = static::$table_name;
        $result     = Database::query(
            "SELECT * FROM $table_name WHERE `id` = $id LIMIT 1"
        );

        $orm = new static();
        foreach ($result as $column => $value)
        {
            $orm->$column = $value;
        }

        return $orm;
    }

    public static function create($values)
    {
        $result = Database::query("PRAGMA table_info('users');");

        $table_columns = [];


        foreach ($result as $row) {
            $table_columns[] = $row['name'];
        }

        $orm_values = [];
        foreach ($values as $key => $value)
        {
            if (in_array($key, $table_columns))
            {
                $orm_values[$key] = $value;
            }
        }

        $d = Database::get();
        $d->insert(static::$table_name, $orm_values);

    }

}