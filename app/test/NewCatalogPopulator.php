<?php

namespace app\test;

use app\models\catalogs\NewInventory;
use app\models\collections\InvoiceItems;
use app\models\collections\Products;
use app\models\collections\Users;
use app\models\catalogs\Inventory;
use app\models\catalogs\OrdersCatalog;
use app\models\catalogs\ReviewsCatalog;
use app\models\catalogs\UsersCatalog;
use Exception;

class NewCatalogPopulator {

    /**
     * @throws Exception
     */
    public static function inventory (Products $products): NewInventory {
        $inventory = NewInventory::getInstance();
        foreach ($products->getItems() as $product) {
            try {
                $inventory->add($product, rand(1, DEFAULT_RESTOCK_QUANTITY));
            } catch (Exception $e) { echo $e; }
        }
        return $inventory;
    }

    /**
     * @throws Exception
     */
    public static function usersCatalog (UsersCatalog $catalog, Users $users): void {
        foreach ($users->getList() as $user) {
           $catalog->add($user);
        }
    }

    /**
     * @throws Exception
     */
    public static function reviewsCatalog (
        ReviewsCatalog $catalog,
        UsersCatalog $users,
        Inventory $inventory
    ): void {
        $reviews = ListGenerator::reviews($users->getUsers(), $inventory->getProducts());
        foreach ($reviews->getList() as $review) {
            $catalog->add($review);
        }
    }

    public static function populateShoppingCarts (UsersCatalog $users, Inventory $inventory): void {
        foreach ($users->getUsers() as $user) {
            NewEntityGenerator::invoice($inventory->getProducts())->transferToTarget($user->getShoppingCart());
        }
    }

    /**
     * @throws Exception
     */
    public static function ordersCatalog (OrdersCatalog $catalog, UsersCatalog $users): void {
        foreach ($users->getUsers() as $user) {
            $order = NewEntityGenerator::order($user);
            if (!is_null($order)) {
                $catalog->getOrders()->addOrder($order);
            }
        }
    }
}