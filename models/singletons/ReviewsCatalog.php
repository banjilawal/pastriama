<?php
namespace models\containers;

use Exception;
use model\abstract\Invoice;
use model\abstract\InvoiceItemList;
use model\abstract\PastryList;
use models\concretes\Customer;
use models\concretes\Pastry;
use models\concretes\Review;
use Shop\Model\collections\ReviewList;

class ReviewsCatalog {
    private static ReviewList $reviews;

    private function __construct () {
        self::$reviews = new ReviewList();
    }

    public static function getCatalog (): ReviewList {
        if (!isset(self::$reviews)) {
            self::$reviews = new self();
        }
        return self::$reviews;
    }

    private function __clone () {}
    private function __wakeup () {}


    public static function search (Customer $customer, \DateTime $startDate, \DateTime $endDate): ReviewList {
        $matches = new ReviewList();
        foreach (self::$reviews as $id => $review) {
            if (
                $review->getCustomer()->equals($customer)
                && $review->getSubmitTime() >= $startDate
                && $review->getSubmitTime() <= $endDate
            ) { $matches->add(self::$reviews[$id]); }
        }
        return $matches;
    }


    /**
     * @throws Exception
     */
    public static function pastrySearch ( Pastry $pastry, Customer $customer,\DateTime $startDate, \DateTime $endDate): PastryList {
        $matches = new ReviewList();
        foreach (self::$reviews as $id => $review) {
            if (
                $review->getCustomer()->equals($customer)
                && $review->getPastry->equals($pastry)
                && $review->getSubmitTime() >= $startDate
                && $review->getSubmitTime() <= $endDate
            ) { $matches->add(self::$reviews[$id]); }
        }
        return $matches;
    }
} // end class