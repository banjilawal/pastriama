<?php

namespace app\models\singletons;

use app\models\abstracts\Model;
use App\Models\Concretes\Pastry;
use App\Models\Concretes\Review;
use App\Models\concretes\User;
use App\models\Lists\ReviewList;
use DateTime;
use Exception;

class ReviewCatalog extends Model {
    private static ReviewList $reviews;

    private function __construct () {
        parent::__construct();
        self::$reviews = new ReviewList();
    }

    public static function getCatalog(): ReviewList {
        if (!isset(self::$reviews)) {
            self::$reviews = new ReviewList();
        }
        return self::$reviews;
    }

//    private function __clone () {}
//    private function __wakeup () {}

    /**
     * @throws Exception
     */
    public function addReview (Review $review): void {
        self::$reviews->add($review);
    }

    /**
     * @throws Exception
     */
    public function filterByDate (DateTime $startDate, DateTime $endDate): ReviewList {
        $matches = new ReviewList();
        foreach (self::$reviews as $review) {
            if ($review->getSubmitTime() >= $startDate && $review->getSubmitTime() <= $endDate)
                $matches->add(self::$review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public static function userSearch (User $user, DateTime $startDate, DateTime $endDate): ReviewList {
        return (self::$reviews->filterByDateRange($startDate, $endDate))->filterByUser($user);
    }

    public static function pastrySearch (Pastry $pastry,  DateTime $startDate, DateTime $endDate): ReviewList {
        return (self::$reviews->filterByDateRange($startDate, $endDate))->filterByPastry($pastry);
    }
}