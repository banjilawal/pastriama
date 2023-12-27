<?php
namespace models\containers;

use DateTime;
use Exception;
use model\abstract\Order;
use model\abstract\OrderItemList;
use model\abstract\WishList;
use models\concretes\CreditCard;
use models\concretes\Customer;
use models\concretes\Pastry;
use models\concretes\Review;

class Reviews {
    private static $reviews;

    private function __construct () {
        self::$reviews = array ();
    }

    public static function getReviews (): Reviews|array {
        if (!isset(self::$reviews)) {
            self::$reviews = new self();
        }
        return self::$reviews;
    }

    private function __clone () {}
    private function __wakeup () {}
    

    /**
     * @throws Exception
     */
    public static function add (Review $review): void {
        if (!is_null(self::find($review->getCustomer(), $review->getPastry()))) {
            throw new Exception($review->getCustomer()->getFirstname()
                . ' ' . $review->getCustomer()->getLastname()
                . ' already rated'
                . ' ' . $review->getPastry()->getName()
            );
        }
        self::$reviews[$review->getId()] = $review;
    }

    
    public static function find (Customer $customer, Pastry $pastry): ?Review {
        foreach (self::$reviews as $rating) {
            if ($rating->getCustomer() === $customer && $rating->getPastry() === $pastry)
                return $rating;
        }
        return null;
    }
} // end class