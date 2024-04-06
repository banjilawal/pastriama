<?php

namespace app\models\concretes;

use app\models\abstracts\Entity;

use DateTime;
use Exception;

class Review extends Entity {

    public const MINIMUM_RATING =  0;
    public const MAXIMUM_RATING = 5;
    private User $user;
    private Pastry $pastry;
    private int $rating;
    private string $title;
    private string $comment;
    private DateTime $submissionTime;


    /**
     * @throws Exception
     */
    public function __construct(
        int $id,
        User $user,
        Pastry $pastry,
        int $rating,
        string $title,
        string $comment
    ) {
        parent::__construct($id);
//        if ($rating < self::MINIMUM_RATING || $rating > self::MAXIMUM_RATING) {
//            throw new Exception($rating . ' is outside the range');
//        }
        $this->user = $user;
        $this->pastry = $pastry;
        $this->rating = $rating;
        $this->title = trim($title);
        $this->comment = trim($comment);
        $this->submissionTime = new DateTime(); //DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getPastry (): Pastry {
        return $this->pastry;
    }

    public function getRating (): int {
        return $this->rating;
    }

    public function getTitle (): string {
        return $this->title;
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
                && $this->user->equals( $object->getUser())
                && $this->pastry->equals($object->getPastry())
                && $this->rating === $object->getRating()
                && $this->comment === $object->getComment()
                && $this->submissionTime === $object->getSubmissionTime();
        return false;
    }

    public function __toString (): string {
        return __CLASS__ . parent::__toString() . ' pastry:' . $this->pastry->getName()
            . ' ' . $this->submissionTime->format('Y-m-d H:i:s')
            . ' reviewer:' . $this->user->getFirstname() . ' ' . substr($this->user->getLastname(), 0, 1)
            . ' rating:' . $this->rating
            . ' title:' . $this->title
            . ' comment:' . $this->comment;
    }

    public function toRow (): string {
        $rowName = 'rating-' . $this->pastry->getId() . '-' . $this->user->getId() . '-row';
        return '<tr class="rating-row" id="' . $rowName . '"' . ' onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->pastry->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->user->getFirstname() . ' ' . substr($this->user->getLastname(), 0, 1) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->rating . '</td>'
            . '<td>' . $this->comment . '</td>'
            . '</tr>';
    }

    public function toTable (): string {
        $tableName = 'rating-' . $this->pastry->getId() . '-' . $this->user->getId() . '-table';
        return '<table class="rating-table" id="' . $tableName . '">'
//            . '<thead>'
//            . '<tr>'
//            . '<th>Date</th>'
//            . '<th>Reviewer</th>'
//            . '<th>Pastry</th>'
//            . '<th>Stars</th>'
//            . '<th>Comment</th>'
//            . '</tr>'
//            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->user->getFirstname() . ' ' . substr($this->user->getLastname(), 0, 1) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '</tr>'
            . '<tr><td>' . $this->rating . '</td><td>' .$this->title . '</td></tr>'
            . '<tr><td>' . $this->submissionTime->format('Y-m-d') . '</td></tr>'
//            .
//            . '<td>' . $this->pastry->getName() . '</td>'

            . '<tr><td>' . $this->comment . '</td><tr>'
            . '</tbody>'
            . '</table>';
    }
}