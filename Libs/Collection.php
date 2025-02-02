<?php



/**
 * @template K
 * @template V
 */
class Collection
{
    /**
     * @param array<K,V> $collection
     */
    public function __construct(public array $collection)
    {
    }

    /**
     * @param K $key 
     * @param V $default
     * @return V
     */
    public function get(mixed $key, mixed $default = null): mixed
    {
        return $this->collection[$key] ?? $default;
    }

    /**
     * @param K $key
     * @param V $value
     * @return Collection<K,V>
     */
    public function set($key, $value): Collection
    {
        $this->collection[$key] = $value;
        return $this;
    }

    /**
     * @param callable $closure
     * @return Collection<K, V>
     */
    public function map(callable $closure): Collection
    {
        $this->collection = array_map($closure, $this->collection);
        return $this;
    }

    /**
     * @param callable $closure
     * @return Collection<K, V>
     */
    public function filter(callable $closure): Collection
    {
        $this->collection = array_filter($this->collection, $closure);
        return $this;
    }

    public function pop(): mixed
    {
        $key = array_key_last($this->collection);
        $value = $this->collection[$key];
        unset($this->collection[$key]);

        return $value;
    }

    /**
     * @param K $key
     * @return V
     */
    public function __get($key)
    {
        return $this->collection[$key];
    }

    /**
     * @param K $key
     * @param V $value
     */
    public function __set($key, $value): void
    {
        $this->set($key, $value);
    }
}