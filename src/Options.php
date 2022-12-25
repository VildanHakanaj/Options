<?php


namespace VildanHakanaj\Options;

use ArrayAccess;
use Iterator;
use VildanHakanaj\Options\Traits\Arrayable;
use VildanHakanaj\Options\Traits\Iteratable;

class Options implements ArrayAccess, Iterator
{
    use Iteratable, Arrayable;

    private array $options;

    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Static constructor with array
     * @param array $options
     * @return Options
     */
    public static function fromArray(array $options): Options
    {
        return new self($options);
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
     * Get all the options as an array
     * @return array
     */
    public function all(): array
    {
        return $this->options;
    }

    /**
     * Returns all the keys of the options array
     * @return int[]|string[]
     */
    public function keys()
    {
        return array_keys($this->options);
    }

    /**
     * Return all the values in the options array.
     * @return array
     */
    public function values(): array
    {
        return array_values($this->options);
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
     * Will add the key value only if the key is not already in the options array.
     * @param string $key
     * @param $value
     * @return $this
     */
    public function addIfUnique(string $key, $value): Options
    {
        if($this->has($key)){
            return $this;
        }

        $this->options[$key] = $value;
        return $this;
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

    /**
     * Merges the give array into the options array.
     * If the given array has existing keys in the
     * options array it will override them.
     * @param array $options
     * @return $this
     */
    public function merge(array $options): Options
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * Merges the given key and value to the existing options array.
     * If the key already exist in the array it will override it the existing one.
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function mergeKey(string $key, $value): Options
    {
        $this->options[$key] = $value;
        return $this;
    }

    /**
     * Overrides the options array to the new provided options
     * @param array $options
     * @return $this
     */
    public function override(array $options): Options
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Convert the options into json
     * @return false|string
     */
    public function toJson($flags = null){
        return json_encode($this->options, $flags);
    }
}