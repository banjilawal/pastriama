<?php
namespace models\concretes;

use DateTime;
use Exception;
use global\Constants;
use model\abstracts\Entity;

class Review extends Entity {
    

    private Customer $customer;
    private Pastry $pastry;
    private int $rating;
    private string $comment;
    private \DateTime $submissionTime;
    

    public function __construct(int $id, Customer $customer, Pastry $pastry, int $rating, string $comment) {
        parent::__construct($id);
        if ($rating < Constants::MINIMUM_RATING || $rating > Constants::MAXIMUM_RATING) {
            throw new Exception($rating . ' is outside the range');
        }
        $this->customer = $customer;
        $this->pastry = $pastry;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->submissionTime = DateTime::createFromFormat('U', time());
    }
    
    
    public function getCustomer (): Customer {
        return $this->customer;
    }
    
    
    public function getPastry (): Pastry {
        return $this->pastry;
    }
    
    
    public function getRating (): int {
        return $this->rating;
    }
    
    
    public function getComment (): string {
        return $this->comment;
    }

    
    public function getSubmissionTime (): DateTime {
        return $this->submissionTime;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Review)
            return parent::equals($object)
                && $this->customer->equals( $object->getCustomer())
                && $this->pastry->equals($object->getPastry())
                && $this->rating === $object->getRating()
                && $this->comment === $object->getComment()
                && $this->submissionTime === $object->getSubmissionTime();
        return false;
    }

    
    public function __toString (): string {
        return __CLASS__ . parent::__toString() . ' pastry:' . $this->pastry->getName()
            . ' ' . $this->submissionTime->format('Y-m-d H:i:s')
            . ' reviewer:' . $this->customer->getFirstname() . ' ' . substr($this->customer->getLastname(), 0, 1)
            . ' rating:' . $this->rating
            . ' comment:' . $this->comment;
    }


    public function toRow (): string {
        $rowName = 'rating-' . $this->pastry->getId() . '-' . $this->customer->getId() . '-row';
        return '<tr class="rating-row" id="' . $rowName . '" name="' . $rowName . '" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->pastry->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->customer->getFirstname() . ' ' . substr($this->customer->getLastname(), 0, 1) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->rating . '</td>'
            . '<td>' . $this->comment . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        $tableName = 'rating-' . $this->pastry->getId() . '-' . $this->customer->getId() . '-table';
        return '<table class="rating-table" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>Date</th>'
            . '<th>Reviewer</th>'
            . '<th>Pastry</th>'
            . '<th>Stars</th>'
            . '<th>Comment</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->customer->getFirstname() . ' ' . substr($this->customer->getLastname(), 0, 1) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->rating . '</td>'
            . '<td>' . $this->comment . '</td>'
            . '</tbody>'
            . '</table>';
    }
} // end class