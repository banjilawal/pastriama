<?php

namespace app\handlers;

use app\requests\Request;

class IdExistsHandler extends Handler {
    public function handle (& $array, Request $request): bool {
        if (array_key_exists($request->getFields()['id'], $array)) {
            return true;
        }
        return parent::handle($array, $request);
    }
}


// Create the Chain of Responsibility
$checkExists = new \app\interfaces\responsibilities\CheckIfItemExistsHandler();
$addNewItem = new \app\interfaces\responsibilities\AddNewItemHandler();
$incrementItem = new \app\interfaces\responsibilities\IncrementItemValueHandler();

// Set the chain sequence
$checkExists->setNext($addNewItem); // If item doesn't exist, add it
$addNewItem->setNext($incrementItem); // If item exists, increment it

// Example array
$array = [
    'apple' => 10,
    'banana' => 5,
];

// Test the chain with an item that exists
$checkExists->handle($array, 'apple', 2); // Increments the value of 'apple' by 2

// Test the chain with an item that doesn't exist
$checkExists->handle($array, 'orange', 3); // Adds 'orange' with a value of 3

// Output the updated array
print_r($array); // Output: ['apple' => 12, 'banana' => 5, 'orange' => 3]