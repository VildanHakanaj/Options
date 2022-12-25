<?php


namespace VildanHakanaj\Options;


use ArrayAccess;
use Iterator;

abstract class Collection implements ArrayAccess, Iterator
{
    protected array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    public function current()
    {
        return current($this->options);
    }

    public function next()
    {
        next($this->options);
    }

    public function key()
    {
        return key($this->options);
    }

    public function valid(): bool
    {
        return current($this->options) !== false;
    }

    public function rewind()
    {
        reset($this->options);
    }

    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value)
    {
        if(is_null($offset)){
            $this->options[] = $offset;
        }else{
            $this->options[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
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
    public function __set($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * <p>Return the value for the given key</p> <p>or <b>NULL</b> if the key is not present</p>
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
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