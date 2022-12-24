<?php

namespace Unit;

use PHPUnit\Framework\TestCase;
use VildanHakanaj\Options;

class OptionsTest extends TestCase
{
    protected Options $options;

    protected function setUp(): void
    {
        $this->options = new Options($this->data());
    }

    /**
     * @test
     */
    public function it_can_get_the_options_array()
    {
        $this->assertSame([
            "key1" => "value1",
            "key2" => "value2",
            "key3" => "value3",
            "key4" => "value4",
        ], $this->options->all());

    }

    /**
     * @test
     */
    public function it_can_get_all_the_keys()
    {
        $this->assertSame([
            "key1",
            "key2",
            "key3",
            "key4",
        ], $this->options->keys());
    }

    /**
     * @test
     */
    public function it_can_get_all_the_values()
    {
        $result = $this->options->values();

        $this->assertSame([
            "value1",
            "value2",
            "value3",
            "value4",
        ], $result);
    }

    /**
     * @test
     */
    public function it_can_get_a_item_by_key(){
        $this->assertSame("value1", $this->options->get("key1"));
    }

    /**
     * @test
     */
    public function it_returns_null_if_key_not_found(){
        $this->assertNull($this->options->get("noKey"));
    }

    /**
     * @test
     */
    public function it_check_if_the_options_has_the_key(){
        $this->assertTrue($this->options->has("key1"));
        $this->assertFalse($this->options->has("notFound"));
    }

    /**
     * @test
     */
    public function it_can_merge_an_array()
    {
        $this->options->merge([
            "key2" => "override2",
            "key3" => "value3"
        ]);

        $this->assertSame([
            "key1" => "value1",
            "key2" => "override2",
            "key3" => "value3",
            "key4" => "value4",
        ], $this->options->all());
    }

    /**
     * @test
     */
    public function it_can_merge_a_key_value(){
        $results = $this->options
            ->mergeKey("newKey", "newValue")
            ->mergeKey("key1", "overrideValue1")->all();

        $this->assertSame([
            "key1" => "overrideValue1",
            "key2" => "value2",
            "key3" => "value3",
            "key4" => "value4",
            "newKey" => "newValue"
        ], $results);
    }

    /**
     * @test
     */
    public function it_can_override_the_options_with_the_given_array()
    {

        $result = $this->options->override([
            "key" => "value"
        ])->all();

        $this->assertSame(["key" => "value"], $result);
    }

    protected function data(): array
    {
        return [
            "key1" => "value1",
            "key2" => "value2",
            "key3" => "value3",
            "key4" => "value4",
        ];
    }
}
