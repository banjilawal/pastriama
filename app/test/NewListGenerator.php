<?php declare(strict_types=1);
namespace app\test;

use app\models\catalogs\NewInventory;
use app\models\collections\NewReviews;
use app\models\collections\NewUsers;
use app\models\collections\Products;
use app\models\collections\InvoiceItems;
use app\models\collections\Orders;
use app\models\collections\Users;
use app\utils\Util;
use DateTime;
use Exception;

class NewListGenerator {

    /**
     * @throws Exception
     */
    public static function products (int $size=10): Products {
        if ($size < 1) { throw new Exception( $size . ' is below the lower bounds of list\'s size'); }
        $products = new Products();
        for ($i = 0; $i < $size; $i++) { $products->add(NewEntityGenerator::pastry()); }
        return $products;
    }


    /**
     * @throws Exception
     */
    public static function users (int $size=10): NewUsers {
        if ($size < 1) { throw new Exception( $size . ' is below the lower bounds of list\'s size'); }
        $users = new NewUsers();
        for ($i = 0; $i < $size; $i++) { $users->add(NewEntityGenerator::user()); }
        return $users;
    }

    /**
     * @throws Exception
     */
    public static function shoppingCarts (NewUsers $users): NewUsers {
        $instance = NewInventory::getInstance();
        foreach($users->getList() as $user) {
            $productCount = rand(0, (int)(count($instance->getItems()) / 4));
            for ($i = 0; $i < $productCount; $i++) {
                $item = $instance->getItems()[array_rand($instance->getItems())];
                $cartQuantity = rand(0, (int)($item->getQuantity() / 5));
                if ($cartQuantity > 0) {

                    $user->getCart()->add(
                        $instance->remove($item->getProduct(), $cartQuantity),
                        Util::someDateTime(((new DateTime())->sub(new \DateInterval('P5Y'))), new DateTime())
                    );
                }
            }
        }
        return $users;
    }

    /**
     * @throws Exception
     */
    public static function reviews (NewUsers $users, Products $products): NewReviews {
        $reviews = new NewReviews();
        foreach ($products->getItems() as $product) {
            $totalProductReviews = rand(0, (int) (count($users->getList()) / 6));
            for ($i = 0; $i < $totalProductReviews; $i++) {
                $user = $users->randomUser();
//                echo nl2br('total of reviews of ' . $product->getName() . ' = ' . $totalProductReviews . PHP_EOL);
//                if (count($reviews->filterByUser($user)->filterByProduct($product)->getList()) === 0) {
                    $review = NewEntityGenerator::review($user, $product);
//                    echo('CREATED REVIEW: ' . $review);
                    $reviews->addReview(NewEntityGenerator::review($user, $product));
//                }
            }
        }
        return $reviews;
    }

    /**
     * @throws Exception
     */
    public static function orders (NewUsers $users): NewOrders {
        $orders = new NewOrders();
        foreach ($users->getList() as $user) {
            $order = NewEntityGenerator::order($user);
            $orderSize = rand(0, (count($user->getCart()->getList())));
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
        $products= self::products($numberOfPastries);
        $users = self::users($numberOfUsers);
        $reviews = self::reviews($users, $products);
        $users = self::shoppingCarts($users, $products);
        $orders = self::Orders($users);
        return array('products' => $products, 'users' => $users, 'orders' => $orders, 'reviews' => $reviews);
    }
}