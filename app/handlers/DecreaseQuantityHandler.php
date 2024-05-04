<?php

namespace app\handlers;

use app\requests\Request;

class DecreaseQuantityHandler extends Handler{

    public function handle (&$array, Request $request): bool {
        if ($array[$request->getFields()['id']]->getQuantity() >= $request->getFields()['amount']) {

        }
        return parent::handle($arra, $request);
    }

}



// Concrete handler to increment the existing item's value
class IncrementItemValueHandler extends AbstractHandler {
    public function handle (&$array, $key, $increment): bool {
        if (array_key_exists($key, $array)) {
            $array[$key] += $increment; // Increment the existing item
            return true; // Handled
        }
        return parent::handle($array, $key, $increment); // Pass to the next handler
    }
}