<?php

namespace app\interfaces\visitors;

use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use app\models\catalogs\Inventory;
use app\models\collections\Cart;
use app\models\concretes\Order;

interface AddStoreItem {

    public function cartAdder (Cart $cart, StoreItem $storeItem): void;
    public function inventoryAdder (Inventory $inventory, Product $product, int $quantity): void;
    public function orderAdder (Order $order, StoreItem $storeItem): void;


}