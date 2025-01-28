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

    /** @var array<array{type:'where',column:string,"operator":string,value:string|int}|array{type:'like',column:string,value:string|int}> */
    public array $wheres = [];

    /** @var array<array{join_type:'left'|'inner',table_name:string,key_1:string,key_2:string}> */
    public array $joins = [];

    /** @var array<array{column:string,type:'ASC'|'DESC'}> */
    public array $orders = [];

    public string $table_name = '';

    public function __construct()
    {
        $path = Config::get('base_path').'Database/'.Config::get('database');
        $this->database = new PDO(
            'sqlite:'.$path,
            null,
            null,
            ['fetchMode' => PDO::FETCH_ASSOC]
        );

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
     * @param  array<string|int>  $attributes
     * @return array<array<string,mixed>>
     */
    public function prepared_query(string $query, array $attributes = []): array
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
        $this->clear();

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

    public function where(string $column, string $operator, string|int $value): self
    {
        $this->wheres[] = [
            'type' => 'where',
            'column' => $column,
            'operator' => $operator,
            'value' => $value,
        ];

        return $this;
    }

    public function like(string $column, string|int $value): self
    {
        $this->wheres[] = [
            'type' => 'like',
            'column' => $column,
            'value' => $value,
        ];

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
     * @param  'DESC'|'ASC'  $type
     */
    public function orderby(string $column, string $type): void
    {
        $this->orders[] = [
            'column' => $column,
            'type' => $type,
        ];
    }

    /**
     * @return array<array<string,mixed>>
     */
    public function find(): array
    {
        [$sql, $attributes] = $this->build_query();
        $sql .= ' LIMIT 1';

        return $this->prepared_query($sql, $attributes);
    }

    /**
     * @return array<array<string,mixed>>
     */
    public function find_all(): array
    {
        [$sql, $attributes] = $this->build_query();

        return $this->prepared_query($sql, $attributes);
    }

    /**
     * @param  array<string,string|int>  $attributes
     */
    public function insert(string $table_name, array $attributes): void
    {
        $fields = implode(', ', array_keys($attributes));
        $values = array_map(fn ($k) => ":$k", array_keys($attributes));
        $values = implode(', ', $values);
        $sql = "INSERT INTO $table_name ($fields) VALUES ($values);";
        $this->prepared_query($sql, $attributes);
    }

    /**
     * @param  array<string,string|int>  $values
     */
    public function update(string $table_name, array $values, int $id): void
    {
        $fields = array_map(fn ($k) => "$k = :$k", array_keys($values));

        $update_statment = implode(', ', $fields);
        $sql = "UPDATE $table_name SET $update_statment WHERE id = $id";

        $this->prepared_query($sql, $values);
    }

    public function delete(string $table_name, int $id): void
    {
        $sql = "DELETE FROM $table_name WHERE id = $id";

        $this->query($sql);
    }

    public function get_last_id(): int
    {
        return (int) $this->database->lastInsertId();
    }

    public function clear(): void
    {
        $this->select = [];
        $this->wheres = [];
        $this->joins = [];
        $this->orders = [];
        $this->table_name = '';
    }

    /**
     * @return array{non-falsy-string, list<string|int>}
     */
    private function build_query(): array
    {
        $sql = 'SELECT ';
        $attributes = $this->select ? [...array_values($this->select)] : [];

        $values = array_map(fn () => '?', $this->select);

        if ($this->select) {
            $sql .= implode(', ', $values).' ';
        } else {
            $sql .= '* ';
        }

        $sql .= "FROM $this->table_name ";

        if ($this->joins) {
            foreach ($this->joins as $join_values) {
                $sql = "{$join_values['join_type']} JOIN {$join_values['table_name']} ON {$join_values['key_1']} = {$join_values['key_2']} ";
            }
        }

        if (! empty($this->wheres)) {
            $sql .= ' WHERE ';
            $total_where = count($this->wheres);
            foreach ($this->wheres as $index => $where_values) {
                $add_and = $index > 0 && $index <= $total_where - 1;
                $sql .= $add_and
                    ? ' AND '
                    : ' ';

                $sql .= match ($where_values['type']) {
                    'where' => $where_values['column'].' '.$where_values['operator'].' ?',
                    'like' => $where_values['column'].' LIKE ? ',
                };

                if ($where_values['type'] === 'like') {
                    $where_values['value'] = "%{$where_values['value']}%";
                }

                $attributes[] = $where_values['value'];
            }
        }

        if (! empty($this->orders)) {
            $sql .= ' ORDER BY ';
            $total_orders = count($this->orders);
            foreach ($this->orders as $index => $order) {
                $add_comma = $index > 0 && $index <= $total_orders - 1;
                $sql .= $add_comma
                    ? ', '
                    : ' ';
                $sql .= $order['column'].' '.$order['type'];
            }
        }

        return [$sql, $attributes];
    }
}
