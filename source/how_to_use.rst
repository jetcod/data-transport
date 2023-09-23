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

