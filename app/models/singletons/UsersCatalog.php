<?php

namespace app\models\singletons;

use app\models\abstracts\Model;
use App\Models\Concretes\Pastry;
use App\Models\Concretes\Review;
use App\Models\concretes\User;
use App\models\Lists\ReviewList;
use app\models\lists\Users;
use DateTime;
use Exception;

class UsersCatalog extends Model {
    private static $instance;
    protected static Users $users;

    private function __construct () {
        parent::__construct();
        self::$users = new Users();
    }

    public static function getInstance(): UsersCatalog {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

//    private function __clone () {}
    public function __wakeup () {}

    public function getUsers (): Users {
        return self::$users;
    }

    /**
     * @throws Exception
     */
    public function add (User $user): void {
        self::$users->add($user);
    }

    public function randomUser (): User {
        return self::$users->getItems()[array_rand(self::$users->getItems())];
    }

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