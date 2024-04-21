<?php

namespace app\test;

use app\models\lists\Products;
use app\models\lists\Users;
use app\models\singletons\Inventory;
use app\models\singletons\OrdersCatalog;
use app\models\singletons\ReviewsCatalog;
use app\models\singletons\UsersCatalog;
use Exception;

class CatalogPopulator {

    /**
     * @throws Exception
     */
    public static function inventory (Inventory $inventory, Products $invoice): void {
        foreach ($invoice->getList() as $item) {
            $inventory->add($item);
        }
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
        $reviews = ListGenerator::reviews($users->getUsers(), $inventory->getItems());
        foreach ($reviews->getList() as $review) {
            $catalog->add($review);
        }
    }

    public static function populateShoppingCarts (UsersCatalog $users, Inventory $inventory): void {
        foreach ($users->getUsers() as $user) {
            EntityGenerator::invoice($inventory->getItems())->transferToTarget($user->getShoppingCart());
        }
    }

    /**
     * @throws Exception
     */
    public static function ordersCatalog (OrdersCatalog $catalog, UsersCatalog $users): void {
        foreach ($users->getUsers() as $user) {
            $order = EntityGenerator::order($user);
            if (!is_null($order)) {
                $catalog->getOrders()->addOrder($order);
            }
        }
    }
}