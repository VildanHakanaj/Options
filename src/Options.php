<?php


namespace VildanHakanaj;


class Options
{

    private array $options;

    public function __construct(array $options = []){
        $this->options = $options;
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

}