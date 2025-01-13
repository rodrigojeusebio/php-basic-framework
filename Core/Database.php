<?php

namespace Core;

use Libs\Singleton;
use Libs\Arr;

class Database extends Singleton
{
    public \PDO $database;

    public array $select = [];
    public array $wheres = [];
    public array $joins = [];
    public string $table_name = '';

    public function __construct()
    {
        $path           = Config::get('base_path').'Database/'.Config::get('database');
        $this->database = new \PDO("sqlite:".$path, null, null);
    }

    public static function get(): static
    {
        return static::get_instance();
    }

    public static function query(string $query)
    {
        return static::get_instance()->database->query($query, fetchMode: \PDO::FETCH_ASSOC)->fetchAll();
    }

    public function select(string|array $value): self
    {
        $select_values = Arr::wrap($value);

        foreach ($select_values as $value)
        {
            $this->select[] = $value;
        }

        return $this;
    }

    public function from($table_name): self
    {
        $this->table_name = $table_name;

        return $this;
    }

    public function where($column, $operator, $value): self
    {
        $this->wheres[] = [$column, $operator, $value];

        return $this;
    }

    public function join($table_name, $key_1, $key_2, $join_type): self
    {
        $this->joins[] = [$table_name, $key_1, $key_2, $join_type];

        return $this;
    }

    public function find()
    {
        $sql = $this->build_query();
        $sql .= ' LIMIT 1';

        return $this::query($sql);
    }

    public function find_all()
    {
        $sql = $this->build_query();
    }

    private function build_query(): string
    {
        $sql = 'SELECT ';
        if ($this->select)
        {
            $sql .= implode(', ', $this->select).' ';
        }
        else
        {
            $sql .= '* ';
        }

        $sql .= "FROM $this->table_name ";

        if ($this->joins)
        {
            foreach ($this->joins as $join_values)
            {
                $sql = "{$join_values['join_type']} JOIN {$join_values['table_name']} ON {$join_values['key_1']} = {$join_values['key_2']} ";
            }
        }

        if ($this->wheres)
        {
            $sql .= ' WHERE ';
            $total_where = count($this->wheres);
            foreach ($this->wheres as $index => $where_values)
            {
                $add_and = $index != 0 || $index == $total_where;
                $sql .= ($add_and ? ' AND ' : ' ').implode(' ', $where_values);
            }
        }

        return $sql;
    }

    public function insert(string $table_name, array $values): void
    {
        $fields = implode(', ', array_keys($values));
        $values = implode(', ', $values);
        $sql    = "INSERT INTO $table_name ($fields) VALUES ($values);";
        $this->query($sql);
    }
}