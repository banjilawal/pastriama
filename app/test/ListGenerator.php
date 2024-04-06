<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\Pastry;
use app\models\lists\InvoiceList;
use app\models\lists\PastryList;
use app\models\lists\ReviewList;
use app\models\lists\UserList;
use Exception;

class ListGenerator {

    /**
     * @throws Exception
     */
    public static function pastryList (int $size=10): PastryList {
        if ($size < 1) {
            throw new Exception( $size . ' is outsize the acceptable size of a list');
        }
        $list = new PastryList();
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
    public static function userList (int $size=10): UserList {
        if ($size < 1) {
            throw new Exception( $size . ' is outsize the acceptable size of a list');
        }
        $list = new UserList();
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
    public static function addReviews (ReviewList $reviews, UserList $users, Pastry $pastry, int $numberOfReviews): void {
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
    public static function reviewList (UserList $users, PastryList $pastries): ReviewList {
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
    public static function invoiceList (UserList $users, PastryList $pastries): InvoiceList {
        $list = new InvoiceList();
        foreach ($users->getItems() as $user) {
            $list->add(EntityGenerator::invoice($user, $pastries));
        }
        return $list;
    }

    /**
     * @throws Exception
     */
    public static function lists (int $numberOfUsers=30, int $numberOfPastries=90): array {
        $users = self::userList($numberOfUsers);
        $pastries = self::pastryList($numberOfPastries);
        $invoices = self::invoiceList($users, $pastries);
        $reviews = self::reviewList($users, $pastries);
        return array('users' => $users, 'pastries' => $pastries, 'invoices' => $invoices, 'reviews' => $reviews);
    }
}