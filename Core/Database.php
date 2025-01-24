<?php

declare(strict_types=1);

namespace Core;

use Helpers\Arr;
use Libs\Singleton;
use PDO;

final class Database extends Singleton
{
    public PDO $database;

    /** @var array<string> */
    public array $select = [];

    /** @var array<int,array<string>> */
    public array $wheres = [];

    /** @var array<array{join_type:'left'|'inner',table_name:string,key_1:string,key_2:string}> */
    public array $joins = [];

    public string $table_name = '';

    public function __construct()
    {
        $path = Config::get('base_path').'Database/'.Config::get('database');
        $this->database = new PDO('sqlite:'.$path, null, null);
    }

    public static function get(): static
    {
        return self::get_instance();
    }

    /**
     * @return array<array<string,mixed>>
     */
    public static function query(string $query): array
    {
        $result = [];
        $query = static::get_instance()->database->query($query, fetchMode: PDO::FETCH_ASSOC);

        if ($query) {
            /**
             * @var array<array<string,mixed>>
             */
            $result = $query->fetchAll();
        }

        return $result;
    }

    /**
     * @param  array<string,mixed>  $attributes
     * @return array<array<string,mixed>>
     */
    public function prepared_query(string $query, array $attributes): array
    {
        $result = [];

        $query = $this->database->prepare($query);
        $query->execute($attributes);

        if ($query) {
            /**
             * @var array<array<string,mixed>>
             */
            $result = $query->fetchAll(mode: PDO::FETCH_ASSOC);
        }

        return $result;
    }

    /**
     * @param  string|array<string>  $value
     */
    public function select(string|array $value): self
    {
        $select_values = Arr::wrap($value);

        foreach ($select_values as $value) {
            $this->select[] = $value;
        }

        return $this;
    }

    public function from(string $table_name): self
    {
        $this->table_name = $table_name;

        return $this;
    }

    public function where(string $column, string $operator, string $value): self
    {
        $this->wheres[] = [$column, $operator, $value];

        return $this;
    }

    /**
     * @param  'inner'|'left'  $join_type
     */
    public function join(string $table_name, string $key_1, string $key_2, string $join_type): self
    {
        $this->joins[] = [
            'join_type' => $join_type,
            'table_name' => $table_name,
            'key_1' => $key_1,
            'key_2' => $key_2,
        ];

        return $this;
    }

    /**
     * @return array<array<string,mixed>>
     */
    public function find(): array
    {
        $sql = $this->build_query();
        $sql .= ' LIMIT 1';

        return $this::query($sql);
    }

    public function find_all(): void
    {
        $sql = $this->build_query();
    }

    /**
     * @param  array<string,mixed>  $attributes
     */
    public function insert(string $table_name, array $attributes): void
    {
        $fields = implode(', ', array_keys($attributes));
        $values = array_map(fn ($e) => '?', $attributes);
        $values = implode(', ', $attributes);
        $sql = "INSERT INTO $table_name ($fields) VALUES ($values);";
        $this->prepared_query($sql, $attributes);
    }

    /**
     * @param  array<string,mixed>  $values
     */
    public function update(string $table_name, array $values, int $id): void
    {
        $fields = array_map(fn ($k) => "$k = :$k", array_keys($values));

        $update_statment = implode(', ', $fields);
        $sql = "UPDATE $table_name SET $update_statment WHERE id = $id";

        $this->prepared_query($sql, $values);
    }

    public function get_last_id(): int
    {
        return (int) $this->database->lastInsertId();
    }

    private function build_query(): string
    {
        $sql = 'SELECT ';
        if ($this->select) {
            $sql .= implode(', ', $this->select).' ';
        } else {
            $sql .= '* ';
        }

        $sql .= "FROM $this->table_name ";

        if ($this->joins) {
            foreach ($this->joins as $join_values) {
                $sql = "{$join_values['join_type']} JOIN {$join_values['table_name']} ON {$join_values['key_1']} = {$join_values['key_2']} ";
            }
        }

        if ($this->wheres) {
            $sql .= ' WHERE ';
            $total_where = count($this->wheres);
            foreach ($this->wheres as $index => $where_values) {
                $add_and = $index !== 0 || $index === $total_where - 1;
                $sql .= ($add_and ? ' AND ' : ' ').implode(' ', $where_values);
            }
        }

        return $sql;
    }
}
