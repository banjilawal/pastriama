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


// Define the interface for handling requests
interface Handler {
    public function setNext (Handler $handler): Handler;

    public function handle (array $product);
}

// Abstract class implementing the Handler interface
abstract class AbstractHandler implements Handler {
    private $nextHandler;

    public function setNext (Handler $handler): Handler {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle (array $product) {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($product);
        }

        return null;
    }
}

// Concrete handler to add a new product to the inventory
class AddNewProductHandler extends AbstractHandler {
    private $inventory;

    public function __construct (array &$inventory) {
        $this->inventory = &$inventory;
    }

    public function handle (array $product) {
        $productId = $product['id'];

        if (!isset($this->inventory[$productId])) {
            $this->inventory[$productId] = $product;
            echo "Product added to inventory.\n";
        } else {
            echo "Product already exists in inventory.\n";
        }

        return parent::handle($product);
    }
}

// Concrete handler to increase the quantity of an existing product
class IncreaseQuantityHandler extends AbstractHandler {
    private $inventory;

    public function __construct (array &$inventory) {
        $this->inventory = &$inventory;
    }

    public function handle (array $product) {
        $productId = $product['id'];

        if (isset($this->inventory[$productId])) {
            $this->inventory[$productId]['quantity'] += $product['quantity'];
            echo "Quantity increased for product in inventory.\n";
        }

        return parent::handle($product);
    }
}

// Example usage
$inventory = [];

// Construct the chain of responsibility
$addNewProductHandler = new AddNewProductHandler($inventory);
$increaseQuantityHandler = new IncreaseQuantityHandler($inventory);

$addNewProductHandler->setNext($increaseQuantityHandler);

// Simulate adding new products and increasing quantities
$addNewProductHandler->handle(['id' => 1, 'name' => 'Product A', 'quantity' => 10]);
$addNewProductHandler->handle(['id' => 2, 'name' => 'Product B', 'quantity' => 20]);
$addNewProductHandler->handle(['id' => 1, 'name' => 'Product A', 'quantity' => 5]);

print_r($inventory);