# Data Transfer Object (DTO)

[![Actions Status](https://github.com/jetcod/data-transport/actions/workflows/php.yml/badge.svg?style=for-the-badge&label=%3Cb%3EBuild%3C/b%3E)](https://github.com/jetcod/data-transport/actions)


[![Latest Stable Version](https://img.shields.io/packagist/v/jetcod/data-transport?label=Latest%20Stable%20Version)](https://packagist.org/packages/jetcod/data-transport)
[![Total Downloads](https://img.shields.io/packagist/dt/jetcod/data-transport?label=Total%20Downloads)](https://packagist.org/packages/jetcod/data-transport)
[![License](https://img.shields.io/github/license/jetcod/data-transport?label=License)](https://github.com/jetcod/eloquent-repository/blob/main/LICENSE)


## Overview

**Data Transport** is a PHP package that provides a simple and efficient way to transport data within your application. With Data Transport, you can easily define and manage your data structures, ensuring that your application's data is well-organized and easy to work with. Get started today and streamline your data transport process with Data Transport!

Check out our [documentation](https://jetcod.github.io/data-transport) for more details.

## Installation

To install `jetcod/data-transport`, you can use Composer, the dependency manager for PHP. Run the following command in your terminal:

```sh
composer require jetcod/data-transport
```

## Usage

It is straightforward to employ `jetcod/data-transport`. To begin, create a customized data object class that extends `Jetcod\DataTransport\AbstractDTO`.

```php
<?php 

namespace App\DTO;

use Jetcod\DataTransport\AbstractDTO;

class Student extends AbstractDTO
{
}
```

Next, construct your class and inject your array of data into it.

```php
<?php 

$data = [
    'name' => 'John Doe',
    'email' => 'john.doe@example.com',
];

$dto = new \App\DTO\Student($data);
```

Alternatively, you can assign values to individual class attributes:

```php
<?php 

$dto = new \App\DTO\Student();

$dto->name = "John Doe";
$dto->email = 'john.doe@example.com';
```

In addition to the traditional method of creating a class, you can also utilize the convenient make function to create instances of the class. The make function simplifies the process and provides an alternative way to initialize objects.

```php
<?php 

$dto = \App\DTO\Student::make($data);
```

By utilizing the data transfer object, one can prevent the occurrence of exceptions when attempting to access an undefined class attribute. In such cases, the data transfer object will consistently return `null`.

```php
$dto = new \App\DTO\Student();

var_dump($dto->name);   // Returns null
```
Additionally, it offers the opportunity to specify custom data types.

## Initialization Hook

Starting from version 1.1.2, an `init()` method can be defined within any derived class for additional initialization logic. This method, if defined, will be automatically called after the attributes are assigned in the constructor. You can use this method to perform any necessary setup or initialization tasks.

```php
class Student extends AbstractDTO
{
    protected function init()
    {
        // Custom initialization logic
    }
}
```

## Functions

The following functions are available in the DTO class:

### `__construct(?array $attributes = [])`

The constructor function creates a new instance of the DTO class and initializes it with the given data array.

### `has(string $key): bool`

The has() function checks if the specified key exists in the DTO class data and returns a boolean value.

It works the same as `isset()` php built-in function. For example if you have object:

```php
$student = new Student([
    'first_name' => 'John',
    'last_name' => 'Doe',
    'email' => 'john.doe@example.com'
]);
```

then both functions will produce an identical outcome:

```php
isset($student->email);  // Returns true
isset($student->phone);  // Returns false
```
or
```php
$student->has('email');  // Returns true
$student->has('phone');  // Returns false
```



### `toArray()`

The toArray() function returns an array representation of the DTO class data.

### `toJson(int $options = 0)`

The toJson() function returns a JSON representation of the DTO class data.

Other than above functions, it has the following magic functions:

| Function | Description |
|----------|-------------|
| `__set(string $key, $val)` | sets the value of the specified attribute |
| `__get(string $key)` | returns the value of the specified attribute |
| `__isset(string $key)` | determines if the attribute has been set |
| `__unset(string $key)` | unsets the specified attribute |

## License

This project is licensed under the MIT License - see the [LICENSE](./LICENSE) file for details.
