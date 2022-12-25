<?php


namespace VildanHakanaj\Options\Traits;


trait Iteratable
{
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
}