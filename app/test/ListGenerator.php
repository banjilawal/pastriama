<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\InventoryItem;
use app\models\concretes\Pastry;
use app\models\collections\InvoiceItems;
use app\models\collections\Orders;
use app\models\collections\Pastries;
use app\models\collections\Reviews;
use app\models\collections\Users;
use Exception;

class ListGenerator {

    /**
     * @throws Exception
     */
    public static function pastries (int $size=10): Pastries {
        if ($size < 1) {
            throw new Exception( $size . ' is below the lower bounds of list\'s size');
        }
        $pastries = new Pastries();
        for ($i = 0; $i < $size; $i++) {
//            echo app\test\EntityGenerator::pastryName();
//            echo 'pastry# ' . $i . '<br>' . PHP_EOL;
            $pastries->add(NewEntityGenerator::pastry());
        }
        return $pastries;
    }

    /**
     * @throws Exception
     */
    public static function products (Pastries $pastries): InvoiceItems {
        $products = new InvoiceItems();
        foreach ($pastries->getList() as $pastry) {
            $products->add($pastry, rand((RESTOCK_LEVEL * 2), DEFAULT_RESTOCK_QUANTITY)); ;
        }
        return $products;
    }


    /**
     * @throws Exception
     */
    public static function users (int $size=10): Users {
        if ($size < 1) {
            throw new Exception( $size . ' is below the lower bounds of list\'s size');
        }
        $users = new Users();
        for ($i = 0; $i < $size; $i++) {
//            echo 'user#' . $i . '<br>' . PHP_EOL;
            $users->add(NewEntityGenerator::user());
        }
        return $users;
    }

    public static function fillShoppingCarts (Users $users, InvoiceItems $products): Users {
        foreach($users->getList() as $user) {
            $shoppingCartSize = rand(0, (int) (count($products->getList()) / 4));
            for ($i = 0; $i < $shoppingCartSize; $i++) {
                $purchaseAmount = rand(1, (MAX_QUANTITY_PER_ORDER / 4));
                $product = $products->getList()[array_rand($products->getList())];
                if ($product->getQuantity() - $purchaseAmount === 0) {
                    $products[$product->getId()]->transfer($user->getShoppingCart(), $purchaseAmount);
                }
            }
        }
        return $users;
    }

    /**
     * @throws Exception
     */
    public static function reviews (Users $users, Pastries $pastries): Reviews {
        $reviews = new Reviews();
        foreach ($pastries->getList() as $pastry) {
            $numberOfReviews = rand(1, (int)(count($users->getList()) / 4));
            for ($i = 0; $i < $numberOfReviews; $i++) {
                $user = $users->getList()[array_rand($users->getList())];
                if (count($reviews->filterByUser($user)->filterByPastry($pastry)->getList()) === 0) {
                    $review = NewEntityGenerator::review($user, $pastry);
//                    echo('CREATED REVIEW: ' . $review);
                    $reviews->addReview($review);
                }
            }
        }
        return $reviews;
    }

    /**
     * @throws Exception
     */
    public static function orders (Users $users): Orders {
        $orders = new Orders();
        foreach ($users->getList() as $user) {
            $order = NewEntityGenerator::order($user);
            $orderSize = rand(0, (count($user->getShoppingCart()->getList())));
            for ($i = 0; $i < $orderSize; $i++) {
                $product = $user->getShoppingCart()->randomProduct(); //->getList()[array_rand($user->getShoppingCart()->getList())];
                if (!$order->getInvoice()->contains($product)) {
                    $order->getInvoice()->getFromSource($user->getShoppingCart(), $product);
                    $orders->addOrder($order);
                }
            }
        }
        return $orders;
    }

    /**
     * @throws Exception
     */
    public static function lists (int $numberOfUsers=30, int $numberOfPastries=90): array {
        $pastries = self::pastries($numberOfPastries);
        $users = self::users($numberOfUsers);
        $products = self::products($pastries);
        $reviews = self::reviews($users, $pastries);
        $users = self::fillShoppingCarts($users, $products);
        $orders = self::Orders($users);
        return array('products' => $products, 'users' => $users, 'orders' => $orders, 'reviews' => $reviews);
    }
}