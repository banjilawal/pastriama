<?php

namespace app\models\collections;

use app\models\abstracts\Model;
use app\models\concretes\Pastry;
use app\models\concretes\NewReview;
use app\models\concretes\User;
use DateTime;
use Exception;

class Reviews extends Model {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): NewReview|array {
        return $this->list;
    }

    /**
     * @throws Exception
     */
    public function addReviews (Reviews $reviews): void {
        foreach ($reviews as $id => $review) {
            echo println('adding review' . $review . PHP_EOL);
            $this->addReview($review);
        }
    }


    /**
     * @throws Exception
     */
    public function addReview (NewReview $review): void {
        if (array_key_exists($review->getId(), $this->list)) {
            throw new Exception('A review with that id ' . $review->getId() . ' already exists');
        }
//        foreach ($this->list as $r) {
//            if ($r->getUser()->equals($review->getUser()) && $r->getPastry()->equals($review->getPastry())) {
//                $message = $r->getUser()->printName() . '=' . $review->getUser()->printName() . ' and '
//                    . ' ' . $r->getPastry()->getName() . ' = '
//                . $review->getPastry()->getName();
//                throw new Exception($message);
//            }
//
//        }
//        if (!is_null($this->search($review->getUser(), $review->getPastry()))) {
//            throw new Exception($review->getUser()->printName()
//                . ' already reviewed ' . $review->getPastry()->getName());
//        }
        $this->list[$review->getId()] = $review;
    }


    /**
     * @throws Exception
     */
    public function removeReviews (Reviews $reviews): void {
        foreach ($reviews as $review) {
            $this->remove($review);
        }
    }


    /**
     * @throws Exception
     */
    public function remove (NewReview $review): void {
        if (!array_key_exists($review->getId(), $this->list)) {
            throw new Exception($review->getId() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->list[$review->getId()]);
    }

    /**
     * @throws Exception
     */
    public function filterByRating (int $rating): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getRating() === $rating)
                $matches->addReview($review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByPastry (Pastry $pastry): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getPastry()->equals($pastry))
                $matches->addReview($review);
        }
        return $matches;
    }

    /**
     * @throws Exception
     */
    public function filterByUser (User $user): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getUser()->equals($user))
                $matches->addReview($review);
        }
        return $matches;
    }


    /**
     * @throws Exception
     */
    public function filterByDateRange (DateTime $startDate, DateTime $endDate): Reviews {
        $matches = new Reviews();
        foreach ($this->list as $review) {
            if ($review->getSubmitTime() >= $startDate && $review->getSubbmitTime() <= $endDate)
                $matches->addReview($review);
        }
        return $matches;
    }

    public function sortByRating (): void {
        usort($this->list, 'compareByRating');
    }

    public function compareByRating (NewReview $a, NewReview $b): int {
        return $a->getRating() - $b->getRating();
    }

    /**
     * @throws Exception
     */
    public function search (User $user, Pastry $pastry): Reviews {
        return $this->filterByUser($user)->filterByPastry($pastry);
    }

    public function getAverageRating (): int {
        if (count($this->list) == 0) {
            return 0;
        }
        $sum = 0;
        foreach ($this->list as $review) {
            $sum += $review->getRating();
        }
        return $sum / count($this->list);
    }

    public function __toString  (): string {
        $string = nl2br('Reviews:');
        foreach ($this->list as $id => $review) {
            $string  .= nl2br($review . PHP_EOL);
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table id="reviewsTable">'
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
        foreach ($this->list as $id => $review) {
            $elem .= '<tr>' . $review->toTable() . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }

    public function randomReview (): NewReview {
        return $this->list[array_rand($this->list)];
    }
}