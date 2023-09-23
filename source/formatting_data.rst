.. _formatting_data:

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