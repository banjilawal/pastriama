<?php declare(strict_types=1);
namespace app\test;

use app\models\concretes\Pastry;
use app\models\concretes\Review;
use app\models\concretes\User;

use Exception;

class TestReview {
    private const FOOD_REVIEWS = DATASETS . DIRECTORY_SEPARATOR . 'food_reviews.csv';

    private static function reviewContent (): array {
        $lines = file(self::FOOD_REVIEWS);
        $index = rand(2, count($lines) -1);
        $data = explode(',', $lines[$index]);
//        print_r($data);
        $title = trim($data[0], '"');
        $comment = trim($data[1], '"');
//        $content[1] = trim($content[1], ' "');
        echo 'reviewContent->TITLE:' . $title . '<br>' . PHP_EOL;
        echo 'reviewContent->COMMENT:' . $comment . '<br>' . PHP_EOL;
        return array('title' => $title, 'comment' => $comment);
    }


    /**
     * @throws Exception
     */
    public static function createReview (int $reviewId, User $user, Pastry $pastry): Review {
        $rating = rand(Review::MINIMUM_RATING, Review::MAXIMUM_RATING);
        $content = self::reviewContent();
        return new Review($reviewId, $user, $pastry, $rating, $content['title'], $content['comment']);
    }
}