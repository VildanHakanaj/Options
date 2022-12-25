# Options
A simple way to manage an options array for site, articles, pages etc.

## Requirements
+ php 7.4 and above

## Installation
### Using composer
```bash
composer require vildanhakanaj/php-options 
```

## Usage

### Instantiate
```php
use VildanHakanaj\Options\Options;

$options = new Options([
    "key1" => "value1",
    "key2" => "value2"
]);
// or
$options = Options::fromArray([
    "key1" => "value1",
    "key2" => "value2"
]);
````
### Set options
```php
// Set options
// Use magic setters
$options->key = "value";
// Merge with key value
$options->mergeKey("key", "value");
// Merge an array with key values
$options->merge(["key" => "value", "key1" => "value1"]);
// override options with the given array 
$options->override(["newKey" => "newValue"]);
// Only add if its not already in the options
$options->addIfUnique("key", "value");
```
### Access options
```php
// Any of the merge operations will override if any of the keys already exists in the options array.
// get value out of options
//Will return null if the key is not found
$value = $options->get("key");
$value = $options->key;
$value = $options["key"];
//Get all values
$values = $options->values();
//Get all keys
$keys = $options->keys();
//Get all options
$array = $options->all();
//Check if the key is in options array
$boolean = $options->has("key");
```
### Filter options
```php
//Filter by value
$filteredOptions = $options->filter(function($option){
    return true; /*logic for filtering*/
});
// Remove the falsy values
$onlyTruthyValues = $options->filter();
//Filter by key
$filteredOptions = $options->filterByKey(function($option){
    return true; /*logic for filtering*/
});
```
### Iterable
```php
foreach(Option::fromArray(["key" => "value"]) as $optionKey => $optionValue){
    // $optionKey = "key";
    // $optionValue = "value";
}
```
