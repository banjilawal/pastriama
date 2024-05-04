<?php

namespace app\handlers;

use app\handlers\Handler;

class AddNewItemHandler extends Handler {
    public function handle (&$array, $key, $item): bool {
        if (!array_key_exists($key, $array)) {
            $array[$key] = $item;
            return true;
        }
        return parent::handle($array, $key, $item);
    }
}