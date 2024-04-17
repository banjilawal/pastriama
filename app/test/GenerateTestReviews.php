<?php

namespace app\test;

use app\models\concretes\Pastry;
use app\models\lists\Pastries;
use app\models\lists\ReviewList;
use app\models\lists\Users;
use Exception;

class GenerateTestReviews {

    /**
     * @throws Exception
     */
    private static function addReviews (ReviewList $reviews, Users $users, Pastry $pastry, int $numberOfReviews): void {
       for ($index = 0; $index < $numberOfReviews; $index++) {
           $user = $users->searchById(array_rand($users->getItems()));
           while (!is_null($reviews->filterByPastry($pastry)->filterByUser($user))) {
               $user = $users->searchById(array_rand($users->getItems()));
           }
           $review = TestReview::createReview(OldPrimitiveGenerator::Id(), $user, $pastry);
           echo 'ADDING REVIEW #' . $index . ' :' . $review . '<br>' . PHP_EOL;
           $reviews->add($review);
       }
    }

    /**
     * @throws Exception
     */
    public static function createReviewList (Pastries $pastries, Users $users, int $numberOfItems): ReviewList {
        $reviewList = new ReviewList();
        for ($index = 0; $index < $numberOfItems; $index++) {
            $pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
            while (!is_null($reviewList->filterByPastry($pastry))) {
                $pastry = $pastries->getItems()[(array_rand($pastries->getItems()))];
            }
            $numberOfReviews = rand(0, count($users->getItems()));
            self::addReviews($reviewList, $users, $pastry, $numberOfReviews);
        }
        return $reviewList;
    }

}