<?php


namespace VildanHakanaj;


use ArrayAccess;
use Iterator;

abstract class Collection implements ArrayAccess, Iterator
{
    protected array $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function current(): mixed
    {
        return current($this->options);
    }

    /**
     * @return void
     */
    public function next(): void
    {
        next($this->options);
    }

    /**
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function key(): mixed
    {
        return key($this->options);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return current($this->options) !== false;
    }

    /**
     * @return void
     */
    public function rewind(): void
    {
        reset($this->options);
    }

    /**
     * @param $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @param $offset
     * @return mixed
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * @param $offset
     * @param $value
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        if(is_null($offset)){
            $this->options[] = $offset;
        }else{
            $this->options[$offset] = $value;
        }
    }

    /**
     * @param $offset
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->options[$offset]);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * @param $key
     * @param $value
     */
    public function __set($key, $value): void
    {
        $this->options[$key] = $value;
    }

    /**
     * <p>Return the value for the given key</p> <p>or <b>NULL</b> if the key is not present</p>
     * @param string $key
     * @return mixed|null
     */
    #[\ReturnTypeWillChange]
    public function get(string $key): mixed
    {
        if (!$this->has($key)) {
            return null;
        }

        return $this->options[$key];
    }

    /**
     * Check if the given key exists in options array.
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->options);
    }
}