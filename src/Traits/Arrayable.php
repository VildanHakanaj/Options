<?php


namespace VildanHakanaj\Options\Traits;


trait Arrayable
{
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
        $this->mergeKey($offset, $value);
    }

    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);
    }
}