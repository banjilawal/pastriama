<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\InvoiceItem;
use app\models\concretes\Pastry;
use app\models\lists\Invoice;
use app\models\lists\Orders;
use app\models\lists\Pastries;
use app\models\lists\ReviewList;
use app\models\lists\Users;
use Exception;

class ListGenerator {

    /**
     * @throws Exception
     */
    public static function pastryList (int $size=10): Pastries {
        if ($size < 1) {
            throw new Exception( $size . ' is outsize the acceptable size of a list');
        }
        $list = new Pastries();
        for ($i = 0; $i < $size; $i++) {
//            echo app\test\EntityGenerator::pastryName();
//            echo 'pastry# ' . $i . '<br>' . PHP_EOL;
            $list->add(EntityGenerator::pastry());
        }
        return $list;
    }

    /**
     * @throws Exception
     */
    public static function userList (int $size=10): Users {
        if ($size < 1) {
            throw new Exception( $size . ' is outsize the acceptable size of a list');
        }
        $list = new Users();
        for ($i = 0; $i < $size; $i++) {
//            echo 'user#' . $i . '<br>' . PHP_EOL;
            $list->add(EntityGenerator::user());
//            $primitive = new app\test\EntityGenerator();
//            $builder = new TestUser($primitive->id(), $primitive->id());
//                $list->add($builder->createUser());
        }
        return $list;
    }

    /**
     * @throws Exception
     */
    public static function addReviews (
        ReviewList $reviews,
        Users      $users,
        Pastry     $pastry,
        int        $numberOfReviews
    ): void {
        $count = 0;
        $availableReviewers = count($users->getItems());
//        echo 'count:' . $count . ' ' . $availableReviewers . ' reviewers are available<br>' . PHP_EOL;
//        $user = $users->searchById(array_rand($users->getItems()));
        while ($count < $numberOfReviews) { //} || $availableReviewers > 0) {
//            while (count($reviews->search($user, $pastry)->getItems()) != 0) {
//                echo $user->getName() . ' already reviewed ' . $pastry->getName();
//                $user = $users->searchById(array_rand($users->getItems()));
//                $availableReviewers--;
//            }
//            echo 'count:' . $count . ' ' . $availableReviewers . ' reviewers are available<br>' . PHP_EOL;
            $user = $users->searchById(array_rand($users->getItems()));
            $reviews->add(EntityGenerator::review($user, $pastry));
            $count++;
            $availableReviewers--;
        }
//        for ($i = 0; $i < $numberOfReviews; $i++) {
//            $user = $users->searchById(array_rand($users->getItems()));
//            while (!is_null($reviews->filterByPastry($pastry)->filterByUser($user))) {
//                $user = $users->searchById(array_rand($users->getItems()));
//            }
////            $review = TestReview::createReview(OldPrimitiveGenerator::Id(), $user, $pastry);
////            echo 'ADDING REVIEW #' . $index . ' :' . $review . '<br>' . PHP_EOL;
//            $reviews->add(app\test\EntityGenerator::review($user, $pastry));
//        }
    }

    /**
     * @throws Exception
     */
    public static function reviewList (Users $users, Pastries $pastries): ReviewList {
        $list = new ReviewList();
        foreach ($pastries->getItems() as $pastry) {
            $numberOfReviews = rand(1, count($users->getItems()) - 1);
//            echo 'generating ' . $numberOfReviews . ' reviews for ' . $pastry->getName() . '<br>' . PHP_EOL;
            self::addReviews($list, $users, $pastry, $numberOfReviews);
//            echo '    added ' . count($list->getItems()) . ' reviews<br>' . PHP_EOL;
        }
//        $totalReviews = rand(1, count($pastries->getItems()));
//        for ($i = 0; $i < $totalReviews; $i++) {
//            $pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
//            while (!is_null($list->filterByPastry($pastry))) {
//                $pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
//            }
//
//            self::addReviews($list, $users, $pastry, $numberOfReviews);
//        }
        return $list;
    }


    /**
     * @throws Exception
     */
    public static function Orders (Users $users, Pastries $pastries): Orders {
        $orders = new Orders();
        foreach ($users->getItems() as $user) {
            $orders->addOrder(EntityGenerator::order($user, $pastries));
        }
        return $orders;
    }


    /**
     * @throws Exception
     */
    public static function inventory (Pastries$pastries): Invoice {
        $inventory = new Invoice();
        foreach ($pastries->getItems() as $pastry) {
            $inventory->add(new InvoiceItem($pastry, 50)); ;
        }
        return $inventory;
    }

    /**
     * @throws Exception
     */
    public static function lists (int $numberOfUsers=30, int $numberOfPastries=90): array {
        $users = self::userList($numberOfUsers);
        $pastries = self::pastryList($numberOfPastries);
        $orders = self::Orders($users, $pastries);
        $reviews = self::reviewList($users, $pastries);
        $inventory = self::inventory($pastries);
        return array('users' => $users, 'inventory' => $inventory, 'orders' => $orders, 'reviews' => $reviews);
    }
}