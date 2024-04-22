<?php

namespace app\models\catalogs;

use app\models\abstracts\Model;
use App\Models\Concretes\Pastry;
use App\Models\Concretes\Review;
use App\Models\concretes\User;
use App\models\Lists\Reviews;
use DateTime;
use Exception;

class ReviewsCatalog extends Model implements ReviewServer {
    private static $instance;
    protected static Reviews $reviews;

    private function __construct () {
        parent::__construct();
        self::$reviews = new Reviews();
    }

    public static function getInstance(): ReviewsCatalog {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

//    private function __clone () {}
    public function __wakeup () {}

    public function getReviews (): Reviews {
        return self::$reviews;
    }

//    /**
//     * @throws Exception
//     */
//    public function add (Review $review): void {
//        self::$reviews->addReview($review);
//    }

//    /**
//     * @throws Exception
//     */
//    public function filterByDate (DateTime $startDate, DateTime $endDate): ReviewList {
//        $matches = new ReviewList();
//        foreach (self::$reviews as $review) {
//            if ($review->getSubmitTime() >= $startDate && $review->getSubmitTime() <= $endDate)
//                $matches->add($review);
//        }
//        return $matches;
//    }
//
//    /**
//     * @throws Exception
//     */
//    public static function userSearch (User $user, DateTime $startDate, DateTime $endDate): ReviewList {
//        return (self::$reviews->filterByDateRange($startDate, $endDate))->filterByUser($user);
//    }
//
//    /**
//     * @throws Exception
//     */
//    public static function pastrySearch (Pastry $pastry, DateTime $startDate, DateTime $endDate): ReviewList {
//        return (self::$reviews->filterByDateRange($startDate, $endDate))->filterByPastry($pastry);
//    }
}