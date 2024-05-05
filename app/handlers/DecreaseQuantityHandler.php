<?php

namespace app\handlers;

use app\requests\Request;

class DecreaseQuantityHandler extends Handler{

    public function handle (&$array, Request $request): bool {
        if ($array[$request->getFields()['id']]->getQuantity() >= $request->getFields()['amount']) {
            $array[$request->getFields()['id']]->decreaseQuantity($request->getFields()['amount']);
            return true;
        }
        return parent::handle($arra, $request);
    }

}