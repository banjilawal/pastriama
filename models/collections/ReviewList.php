<?php
namespace Shop\Model\collections;

use Exception;
use models\concretes\Pastry;
use models\concretes\Review;

class ReviewList {
    private array $reviews;
    
    
    public function __construct () {
        $this->reviews = array();
    }


    public function getReviews (): Review|array {
        return $this->reviews;
    }


    public function addReviews (ReviewList $reviews): void {
        foreach ($reviews as $id => $review) {
            $this->add($review);
        }
    }


    /**
     * @throws Exception
     */
    public function add (Review $review): void {
        if (array_key_exists($review->getId(), $this->reviews)  || !is_null($this->find($review->getPastry()))) {
            throw new Exception('You have already reviewed ' . $review->getPastry()->geName());
        }
        $this->reviews[$review->getId()] = $review;
    }


    /**
     * @throws Exception
     */
    public function removeReviews (ReviewList $reviews): void {
        foreach ($reviews as $id => $review) {
            $this->remove($review);
        }
    }


    /**
     * @throws Exception
     */
    public function remove (Review $review): void {
        if (!array_key_exists($review->getId(), $this->reviews)) {
            throw new Exception($review->getId() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->reviews[$review->getId()]);
    }


    public function search (Pastry $pastry): ?Review {
        foreach ($this->reviews as $id => $review) {
            if ($review->getPastry()->equals($pastry))
                return $review;
        }
        return null;
    } // close search
    

    public function toString  (): string {
        $string = nl2br('Reviews:');
        foreach ($this->reviews as $id => $review) {
            $string  .= nl2br($review);
        }
        return $string;
    }


    public function toTable (): string {
        $elem = '<table class="review-table" id="review-table" name="review-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Date</th>'
            . '<th>Reviewer</th>'
            . '<th>Pastry</th>'
            . '<th>Stars</th>'
            . '<th>Comment</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->reviews as $id => $review) {
            $elem .= $review->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}