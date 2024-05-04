<?php

namespace app\test;

use app\models\catalogs\Inventory;
use app\models\catalogs\NewReviewsCatalog;
use app\models\catalogs\UsersCatalog;
use app\models\collections\InvoiceItems;
use app\models\collections\Reviews;
use app\models\collections\Users;
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
    public static function inventory (Products $products): Inventory {
        $inventory = Inventory::getInstance();
        foreach ($products->getItems() as $product) {
            try {
                $inventory->add($product, rand(30, DEFAULT_RESTOCK_QUANTITY));
            } catch (Exception $e) { echo $e; }
        }
        return $inventory;
    }

    public static function reviewsCatalog (Reviews $reviews): NewReviewsCatalog {
        $catalog = NewReviewsCatalog::getInstance();
        foreach ($reviews->getList() as $review) {
            try {
                $catalog->getReviews()->addReview($review);
            } catch (Exception $e) { echo $e; }
        }
        return $catalog;
    }

    /**
     * @throws Exception
     */
    public static function usersCatalog (Users $users): UsersCatalog {
        $catalog = UsersCatalog::getInstance();
        foreach ($users->getList() as $user) {
           $catalog->getUsers()->add($user);
        }
        return $catalog;
    }

    /**
//     * @throws Exception
//     */
//    public static function reviewsCatalog (
//        ReviewsCatalog $catalog,
//        UsersCatalog $users,
//        Inventory $inventory
//    ): void {
//        $reviews = ListGenerator::reviews($users->getUsers(), $inventory->getProducts());
//        foreach ($reviews->getList() as $review) {
//            $catalog->add($review);
//        }
//    }

//    public static function populateShoppingCarts (UsersCatalog $users, Inventory $inventory): void {
//        foreach ($users->getUsers() as $user) {
//            EntityGenerator::invoice($inventory->getProducts())->transferToTarget($user->getShoppingCart());
//        }
//    }
//
//    /**
//     * @throws Exception
//     */
//    public static function ordersCatalog (OrdersCatalog $catalog, UsersCatalog $users): void {
//        foreach ($users->getUsers() as $user) {
//            $order = EntityGenerator::order($user);
//            if (!is_null($order)) {
//                $catalog->getOrders()->addOrder($order);
//            }
//        }
//    }
}