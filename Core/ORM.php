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

}
;