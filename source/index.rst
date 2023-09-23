.. PHP Data Transport documentation master file, created by
   sphinx-quickstart on Fri Sep 22 17:12:00 2023.
   You can adapt this file completely to your liking, but it should at least
   contain the root `toctree` directive.

PHP Data Transport documentation!
==============================================

.. toctree::
   :maxdepth: 2
   :caption: Contents:

Overview
########

**Data Transport** is a PHP package that provides a simple and efficient way to transport data within your application. With Data Transport, you can easily define and manage your data structures, ensuring that your application's data is well-organized and easy to work with. Get started today and streamline your data transport process with Data Transport!

Why to Use?
###########

This library offers a straightforward and effective means of transferring data within your application. By utilizing Data Transport you can effortlessly establish and control your data structures, guaranteeing that your application’s data is properly arranged and readily manageable.

It helps to enhance the overall reliability to the system by effectively reducing the risk of failure when accessing DTO object attributes.

Installation
############

To install `jetcod/data-transport`, you can use Composer, the dependency manager for PHP. Run the following command in your terminal:

.. code-block:: sh

   composer require jetcod/data-transport


How to use
##########

Using `jetcod/data-transport` is a straightforward process. You can create customized data object classes by extending `Jetcod\DataTransport\AbstractDTO`. Here's how to initialize and work with these classes:

Creating a Custom DTO
*********************

Begin by creating a custom data object class that extends `AbstractDTO`. This class will serve as the blueprint for your data objects.


.. code-block:: php

   <?php 

   namespace App\DTO;

   use Jetcod\DataTransport\AbstractDTO;

   class Student extends AbstractDTO
   {
   }

Initializing Your Data Object
*****************************

There are two primary methods to initialize your data object with data: using the constructor or assigning values to individual attributes.


Using the Constructor
---------------------

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
---------------------------

In addition to the traditional constructor method, you can also utilize the convenient make function to create instances of your data object class. The make function simplifies the initialization process and provides an alternative way to create objects.

.. code-block:: php

   <?php 

   $data = [
      'name' => 'John Doe',
      'email' => 'john.doe@example.com',
   ];

   $dto = \App\DTO\Student::make($data);


Assigning Values
****************

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
****************************

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

Converting Data
***************

When working with the DTO class, you have the option to convert its data into different formats using the following functions:

Convert into array
------------------

The toArray() function is designed to provide a straightforward method for converting the data within the DTO class into an array format. It returns an associative array representation of the data, making it easy to work with and manipulate in array-based contexts.

**Example usage:**

.. code-block:: php

   <?php

   $dataArray = $dto->toArray();


Convert into json
-----------------

The toJson() function is your tool for transforming the DTO class data into a JSON format. It returns a JSON representation of the data, allowing you to easily share, store, or interact with the data in a structured manner. Optionally, you can specify additional formatting options through the $options parameter to customize the JSON output according to your needs.

**Example usage:**

.. code-block:: php

   <?php

   $jsonData = $dto->toJson(JSON_PRETTY_PRINT);


These conversion functions provide flexibility in how you handle and share your DTO class data, whether you prefer it in array or JSON format.