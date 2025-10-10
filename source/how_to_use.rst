.. _how_to_use:

How to use?
***********

Using `jetcod/data-transport` is a straightforward process. You can create customized data object classes by extending `Jetcod\DataTransport\AbstractDTO`. Here's how to initialize and work with these classes:

Creating a Custom DTO
=====================

Begin by creating a custom data object class that extends `AbstractDTO`. This class will serve as the blueprint for your data objects.


.. code-block:: php

   <?php 

   namespace App\DTO;

   use Jetcod\DataTransport\AbstractDTO;

   class Student extends AbstractDTO
   {
   }

Initializing Your Data Object
=============================

There are two primary methods to initialize your data object with data: using the constructor or assigning values to individual attributes.


Using the Constructor
~~~~~~~~~~~~~~~~~~~~~

1. Import your custom data object class:

.. code-block:: php

   <?php 

   use App\DTO\Student;

   // ...

2. Construct your data object and inject an array of data into it:

.. code-block:: php

   <?php 

   $data = [
      'name' => 'John Doe',
      'email' => 'john.doe@example.com',
   ];

   $dto = new \App\DTO\Student($data);


Utilizing the Make Function
~~~~~~~~~~~~~~~~~~~~~~~~~~~

In addition to the traditional constructor method, you can also utilize the convenient make function to create instances of your data object class. The make function simplifies the initialization process and provides an alternative way to create objects.

.. code-block:: php

   <?php 

   $data = [
      'name' => 'John Doe',
      'email' => 'john.doe@example.com',
   ];

   $dto = \App\DTO\Student::make($data);


Assigning Values
================

1. Import your custom data object class:

.. code-block:: php

   <?php 

   use App\DTO\Student;

   // ...


2. Create an instance of your data object:

.. code-block:: php

   <?php 

   $dto = new \App\DTO\Student();

   // Assign values to individual attributes
   $dto->name = "John Doe";
   $dto->email = 'john.doe@example.com';


Checking attribute existance
============================

The has() function serves the purpose of verifying the presence of a specified key within the data of the DTO class. It returns a boolean value indicating the result of this check.

Its behavior closely resembles that of the PHP built-in function isset(). For instance, if you have an object like this:

.. code-block:: php

   <?php 

   $student = new Student([
      'first_name' => 'John',
      'last_name' => 'Doe',
      'email' => 'john.doe@example.com'
   ]);


Both functions will yield the same result:

.. code-block:: php

   isset($student->email);  // Returns true
   isset($student->phone);  // Returns false

Alternatively, you can achieve the same outcome using the has() function:

.. code-block:: php

   $student->has('email');  // Returns true
   $student->has('phone');  // Returns false

In essence, has() offers a convenient way to perform existence checks within the DTO class data, paralleling the functionality of isset().


Read-only Object
================
Starting from version **1.3.0**, DTOs can be instantiated in read-only mode. This ensures that once created, their attributes cannot be modified, providing an extra layer of immutability and data integrity.

Usage
~~~~~
You can enable read-only mode by passing true as the second parameter when constructing the DTO:


.. code-block:: php

   <?php
   
   use App\DTOs\Student;

   $dto = new Student([
      'fullname' => 'John Doe',
      'email'    => 'john.doe@example.com',
   ], true); // 👈 read-only enabled


Behavior
~~~~~~~~
When a DTO is read-only:

-	Attempting to set a new attribute will throw a ValidationException.
-	Attempting to update an existing attribute will also throw a ValidationException.


Object Validation
=================
Starting from version **1.3.0**, DTOs can now be validated directly using built-in or custom validators. This allows developers to ensure that DTO attributes comply with their defined schema before using or persisting the object.

Defining Validation Rules
~~~~~~~~~~~~~~~~~~~~~~~~~
To enable validation for your DTO, use the HasValidator trait and define your validation rules in the getSchema() method. The keys represent attribute names, and the values define their validation type or rule.

.. code-block:: php

   <?php
   
   use Jetcod\DataTransport\AbstractDTO;
   use Jetcod\DataTransport\Contracts\TypedEntity;
   use Jetcod\DataTransport\Traits\HasValidator;

   class Product extends AbstractDTO implements TypedEntity
   {
      use HasValidator;

      public function getSchema(): array
      {
         return [
               'name'        => 'string',
               'price'       => 'numeric',
               'sku'         => 'string',
               'inStock'     => 'boolean',
               'category_id' => 'numeric',
         ];
      }
   }


Validating the DTO
~~~~~~~~~~~~~~~~~~
You can validate the object using the **validate()** method. It returns a validator result object that contains the validation outcome and any errors found.

.. code-block:: php

   <?php
   
   $product = new Product([
      'name'        => 'Wireless Keyboard',
      'price'       => '39.90',
      'sku'         => 12345, // invalid: should be string
      'inStock'     => true,
      'category_id' => 'electronics', // invalid: should be numeric
   ]);

   $validation = $product->validate();

   if (!$validation->isValid()) {
      dump($validation->errors());
   }

**Output:**

.. code-block:: php

   [
      'sku'         => ['The sku must be a string.'],
      'category_id' => ['The category_id must be numeric.'],
   ]


Built-in Validators
~~~~~~~~~~~~~~~~~~~
The following validation types are supported out of the box:

+---------+---------------------------------------------+
| Type    | Description                                 |
+=========+=============================================+
| string  | Ensures the value is a string.              |
+---------+---------------------------------------------+
| numeric | Ensures the value is numeric.               |
+---------+---------------------------------------------+
| int     | Ensures the value is integer.               |
+---------+---------------------------------------------+
| float   | Ensures the value is float.                 |
+---------+---------------------------------------------+
| boolean | Ensures the value is boolean.               |
+---------+---------------------------------------------+
| array   | Ensures the value is an array.              |
+---------+---------------------------------------------+
| email   | Ensures the value is a valid email address. |
+---------+---------------------------------------------+
| url     | Ensures the value is a valid url.           |
+---------+---------------------------------------------+


Custom Validators
~~~~~~~~~~~~~~~~~
Custom validators allow you to define your own validation logic beyond the built-in types. Use custom validators when you need to enforce specific rules or complex validation that cannot be handled by simple type checks.

To create a custom validator, implement the `ValidatorInterface`, which requires three methods:

- `validate(mixed $value): bool` — Returns true if the value passes validation, false otherwise.
- `getError(): string` — Returns the error message to be used if validation fails.
- `alias(): string` — Returns a string alias for the validator, used for identification.

Here is an example of a custom validator class:


.. code-block:: php

   <?php
   use Jetcod\DataTransport\Contracts\ValidatorInterface;

   class CustomValidator implements ValidatorInterface
   {
      public function validate($value): bool
      {
         // Custom validation logic, e.g., check department code format
         return is_string($value) && preg_match('/^[A-Z]{2,3}-\d{2}$/', $value);
      }

      public function getError(): string
      {
         return 'The department code must follow the format ABC-12 (2–3 uppercase letters, a dash, and 2 digits).';
      }

      public function alias(): string
      {
         return 'custom_validator';    // This only works for built-in validators. It cane be left as empty string.
      }
   }


You can then use this custom validator inside a DTO's **getSchema()** method like this:


.. code-block:: php

   <?php

   use Jetcod\DataTransport\AbstractDTO;
   use Jetcod\DataTransport\Contracts\TypedEntity;
   use Jetcod\DataTransport\Traits\HasValidator;

   class Employee extends AbstractDTO implements TypedEntity
   {
      use HasValidator;

      public function getSchema(): array
      {
         return [
               'firstName'      => 'string',
               'email'          => 'email',
               'roomNo'         => 'numeric',
               'departmentCode' => CustomValidator::class
         ];
      }
   }


When a value fails the custom validation, the DTO will use the error message provided by the custom validator's **getError()** method to report the validation failure.


Strict Mode Validation
~~~~~~~~~~~~~~~~~~~~~~
DTOs support **Strict Mode** which automatically validates the data **during object initialization**. When strict mode is enabled, any validation failure immediately throws a **ValidationException**, preventing the creation of invalid DTO instances.


Usage
^^^^^
Strict mode can be activated by passing `true` as the **third constructor argument**:

.. code-block:: php

   <?php

   use App\DataObjects\Employee;

   // Example: strict mode enabled
   $employee = new Employee([
       'firstName' => null,
       'email'     => 'john.doe@example.com',
   ], false, true);

   // ❌ Throws ValidationException:
   // "The firstName must be a string."


In the example above:

- The **second parameter** (`false`) indicates that the DTO is *not read-only*.
- The **third parameter** (`true`) activates **strict mode validation**.
- Because `firstName` is invalid (`null` instead of `string`), the constructor immediately throws a `ValidationException`.

Behavior
^^^^^^^^
When strict mode is active:

- Validation runs automatically during object creation.
- If any attribute fails its validation rule, a `ValidationException` is thrown with the detailed validation errors.
- The DTO will **not** be created if validation fails.
- This behavior ensures data consistency and integrity at the moment of object instantiation.



**Note:** Strict mode is especially useful in critical data layers where invalid data should never enter your application’s flow.
