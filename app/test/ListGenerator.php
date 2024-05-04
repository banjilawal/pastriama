<?php declare(strict_types=1);
namespace app\test;

use app\models\catalogs\Inventory;
use app\models\collections\Orders;
use app\models\collections\Reviews;
use app\models\collections\Users;
use app\models\collections\Products;
use DateInterval;
use DateTime;
use Exception;

class ListGenerator {

    /**
     * @throws Exception
     */
    public static function products (int $size=10): Products {
        if ($size < 1) { throw new Exception( $size . ' is below the lower bounds of list\'s size'); }
        $products = new Products();
        for ($i = 0; $i < $size; $i++) { $products->add(EntityGenerator::product()); }
        return $products;
    }


    /**
     * @throws Exception
     */
    public static function users (int $size=10): Users {
        if ($size < 1) { throw new Exception( $size . ' is below the lower bounds of list\'s size'); }
        $users = new Users();
        for ($i = 0; $i < $size; $i++) { $users->add(EntityGenerator::user()); }
        return self::shoppingCarts($users);
    }

    /**
     * @throws Exception
     */
    public static function shoppingCarts (Users $users): Users {
        $instance = Inventory::getInstance();
        foreach($users->getList() as $user) {
            $productCount = rand(0, (int)(count($instance->getItems()) / 4));
            for ($i = 0; $i < $productCount; $i++) {
                $item = $instance->random();
                $cartQuantity = rand(0, (int)($item->getQuantity() / 5));
                if ($cartQuantity > 0) {
                    $user->getCart()->add(
                        $instance->remove($item->getProduct(), $cartQuantity),
                        Create::someDateTime(((new DateTime())->sub(new DateInterval('P5Y'))), new DateTime())
                    );
                }
            }
        }
        return $users;
    }

    /**
     * @throws Exception
     */
    public static function reviews (Users $users, Products $products): Reviews {
        $reviews = new Reviews();
        foreach ($products->getItems() as $product) {
            $totalProductReviews = rand(0, (int) (count($users->getList()) / 6));
            for ($i = 0; $i < $totalProductReviews; $i++) {
                $user = $users->randomUser();
//                echo nl2br('total of reviews of ' . $product->getName() . ' = ' . $totalProductReviews . PHP_EOL);
//                if (count($reviews->filterByUser($user)->filterByProduct($product)->getList()) === 0) {
                    $review = EntityGenerator::review($user, $product);
//                    echo('CREATED REVIEW: ' . $review);
                    $reviews->addReview(EntityGenerator::review($user, $product));
//                }
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
            $order = EntityGenerator::order($user);
            if (!is_null($order)) {
                $orders->add(EntityGenerator::order($user));
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