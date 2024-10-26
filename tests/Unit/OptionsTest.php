<?php

use VildanHakanaj\Options;


beforeEach(function () {
    $this->settings = new Options(data());
});

it('can create options from static constructor', function () {
    $options = Options::fromArray([
        "key1" => "value1",
        "key2" => "value2"
    ]);

    expect($options)->toBeInstanceOf(Options::class);

    expect($options->all())->toBe([
        "key1" => "value1",
        "key2" => "value2"
    ]);
});

it('can get the options array', function () {
    expect($this->settings->all())->toBe([
        "key1" => "value1",
        "key2" => "value2",
        "key3" => "value3",
        "key4" => "value4",
    ]);
});

it('can only set key if not present in array', function () {
    $instance = $this->settings->addIfUnique("uniqueKey", "uniqueValue");
    $instance2 = $this->settings->addIfUnique("key1", "alreadyExists");

    expect($instance)->toBeInstanceOf(Options::class);
    expect($instance2)->toBeInstanceOf(Options::class);

    expect($this->settings->get("uniqueKey"))->toBe("uniqueValue");
    $this->assertNotSame("alreadyExists", $this->settings->get("key1"));
    expect($this->settings->get("key1"))->toBe("value1");
});

it('can get all the keys', function () {
    expect($this->settings->keys())->toBe([
        "key1",
        "key2",
        "key3",
        "key4",
    ]);
});

it('can get all the values', function () {
    $result = $this->settings->values();

    expect($result)->toBe([
        "value1",
        "value2",
        "value3",
        "value4",
    ]);
});

it('can get a item by key', function () {
    expect($this->settings->get("key1"))->toBe("value1");
});

it('returns null if key not found', function () {
    expect($this->settings->get("noKey"))->toBeNull();
});

it('check if the options has the key', function () {
    expect($this->settings->has("key1"))->toBeTrue();
    expect($this->settings->has("notFound"))->toBeFalse();
});

it('can get value using magic getters', function () {
    expect($this->settings->key1)->toBe("value1");
    expect($this->settings->notFound)->toBeNull();
});

it('can set value using magic setter', function () {
    $this->settings->magicKey = "magicValue";
    expect($this->settings->get("magicKey"))->toBe("magicValue");
});

it('can get a value using options as array', function () {
    expect($this->settings["key1"])->toBe("value1");
});

it('can check if key isset as an array', function () {
    expect(isset($this->settings["key1"]))->toBeTrue();
    expect(isset($this->settings["notFound"]))->toBeFalse();
});

it('can check set key value as array', function () {
    $this->settings["newKey"] = "newValue";
    expect($this->settings->get("newKey"))->toBe("newValue");
});

it('can unset key from options as array', function () {
    unset($this->settings["key1"]);
    expect($this->settings->get("key1"))->toBeNull();
});

it('can merge an array', function () {
    $options = $this->settings->merge([
        "key2" => "override2",
        "key3" => "value3"
    ]);

    expect($options)->toBeInstanceOf(Options::class);

    expect($this->settings->all())->toBe([
        "key1" => "value1",
        "key2" => "override2",
        "key3" => "value3",
        "key4" => "value4",
    ]);
});

it('can merge a key value', function () {
    $options = $this->settings
        ->mergeKey("newKey", "newValue")
        ->mergeKey("key1", "overrideValue1");
    expect($options)->toBeInstanceOf(Options::class);
    $results = $options->all();

    expect($results)->toBe([
        "key1" => "overrideValue1",
        "key2" => "value2",
        "key3" => "value3",
        "key4" => "value4",
        "newKey" => "newValue"
    ]);
});

it('can override the options with the given array', function () {
    $result = $this->settings->override([
        "key" => "value"
    ])->all();

    expect($result)->toBe(["key" => "value"]);
});

it('can loop over options in foreach', function () {
    $options = new Options([
        "showRightRail" => true,
        "pageTitle" => "Page Title"
    ]);

    $result = [];

    foreach ($options as $key => $value) {
        $result[$key] = $value;
    }

    expect($result)->toBe(["showRightRail" => true, "pageTitle" => "Page Title"]);
});

it('can convert options into json', function () {
    $json = $this->settings->toJson();
    expect($json)->toBeJson();
    expect($json)->toBe('{"key1":"value1","key2":"value2","key3":"value3","key4":"value4"}');
});

it('can filter options array', function () {
    $options = Options::fromArray([
        "key1" => false,
        "key2" => true,
        "key3" => "value1",
        "key4" => 0,
        "key5" => 1
    ]);

    expect($options->filter(fn($option) => !$option))->toBe([
        "key1" => false,
        "key4" => 0,
    ]);

    expect($options->filter())->toBe([
        "key2" => true,
        "key3" => "value1",
        "key5" => 1,
    ]);
});

it('can determine if a field is enabled', function () {
    $this->settings->override([
        'featureA' => true,
        'featureB' => 'Yes',
        'featureC' => 'On',
        'featureD' => 1,
    ]);

    expect($this->settings->isEnabled('featureA'))->toBeTrue();
    expect($this->settings->isEnabled('featureB'))->toBeTrue();
    expect($this->settings->isEnabled('featureC'))->toBeTrue();
    expect($this->settings->isEnabled('featureD'))->toBeTrue();
});

it('can determine if a field is disabled', function () {
    $this->settings->override([
        'featureA' => false,
        'featureB' => 'No',
        'featureC' => 'Off',
        'featureD' => 0,
    ]);

    expect($this->settings->isDisabled('featureA'))->toBeFalse();
    expect($this->settings->isDisabled('featureB'))->toBeFalse();
    expect($this->settings->isDisabled('featureC'))->toBeFalse();
    expect($this->settings->isDisabled('featureD'))->toBeFalse();
});

it('returns the default for is enabled and disabled for non existing keys', function () {
    expect($this->settings->isEnabled('non-existing-key', true))->toBeTrue();
    expect($this->settings->isEnabled('non-existing-key'))->toBeFalse();

    expect($this->settings->isDisabled('non-existing-key'))->toBeTrue();
    expect($this->settings->isDisabled('non-existing-key', false))->toBeFalse();
});

it('can filter options by key', function () {
    $this->settings->merge([
        "key11" => "value11",
        "key123" => "value123"
    ]);

    $filteredOptions = $this->settings->filterByKey(function($key){
        return strpos($key, 'key1') !== false;
    });

    expect($filteredOptions)->toBe([
        "key1" => "value1",
        "key11" => "value11",
        "key123" => "value123"
    ]);
});

function data(): array
{
    return [
        "key1" => "value1",
        "key2" => "value2",
        "key3" => "value3",
        "key4" => "value4",
    ];
}