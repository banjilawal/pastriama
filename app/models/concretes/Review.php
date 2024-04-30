<?php

namespace app\models\concretes;

define ('MINIMUM_RATING', 1);
define ('MAXIMUM_RATING', 5);

use app\models\abstracts\Entity;

use app\models\abstracts\Product;
use DateTime;
use Exception;

class Review extends Entity {

    private User $user;
    private Product $product;
    private int $rating;
    private string $title;
    private string $comment;
    private DateTime $submissionTime;


    /**
     * @throws Exception
     */
    public function __construct(
        int  $id,
        User $user,
        Product $product,
        int $rating,
        string $title,
        string $comment,
        DateTime $submissionTime
    ) {
        parent::__construct($id);
        //echo nl2br(PHP_EOL . 'checking if ' . $rating . ' is in the valid range' . PHP_EOL);
        if ($rating < MINIMUM_RATING || $rating > MAXIMUM_RATING) {
            throw new Exception($rating . ' is outside the range');
        }
        $this->user = $user;
        $this->$product = $product;
        $this->rating = $rating;
        $this->title = $title;
        $this->comment = $comment;
        $this->submissionTime = $submissionTime; // DateTime(); //DateTime::createFromFormat('U', date('Y-m-d H:i:s'));
    }

    public function getUser (): User {
        return $this->user;
    }

    public function getProduct (): Product {
        return $this->product;
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

    /**
     * @throws Exception
     */
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof NewReview) {
            return parent::equals($object)
                && $this->user->equals($object->getUser())
                && $this->product->equals($object->getProduct())
                && $this->title === $object->getTitle()
                && $this->rating === $object->getRating()
                && $this->comment === $object->getComment();
        }
        return false;
    }

    public function __toString (): string {
        return 'id:' . $this->getId()
            . ' product:' . $this->getProduct()->getName()
            . ' submitted:' . $this->submissionTime->format('Y-m-d H:i:s')
            . ' reviewer:' . $this->user->printName() //getFirstname() . ' ' . substr($this->user->getLastname(), 0, 1)
            . ' title:' . $this->title
            . ' rating:' . $this->rating
            . ' comment:' . $this->comment;
    }

    public function toRow (): string {
        return '<tr id="reviewRow_"' . $this->getId() . '" onclick="rowClickHandler(' . $this->getId() . ')">'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format(DATE_TIME_FORMAT) . '</td>'
            . '<td>' . $this->user->printName() . '</td>'
            . '<td>' . $this->getProduct()->getName() . '</td>'
            . '<td>' . $this->title . '</td>'
            . '<td>' . $this->rating . '</td>'
            . '<td>' . $this->comment . '</td>'
            . '</tr>';
    }

    public function toTable (string $tableId=''): string {
        return NewReview::tableHeader($tableId) . '<tbody>' . $this->toRow() . '</tbody></table>';
    }

    public static function ratingSelector (): string {
        $elem = '<label for="rating">How Many Stars</label>'
            . '<select id="rating" name="rating" required>';
        for ($i = MINIMUM_RATING; $i <= MAXIMUM_RATING; $i++) {
            $elem .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

    public static function tableHeader (string $tableId=''): string {
        return '<table id="' . $tableId . '>' //reviewTable_"' . $this->getId() . '>'
            . '<thead>'
            . '<tr>'
            . '<th>Id</th>'
            . '<th>Date</th>'
            . '<th>Reviewer</th>'
            . '<th>Pastry</th>'
            . '<th>Title</th>'
            . '<th>Stars</th>'
            . '<th>Comment</th>'
            . '</tr>'
            . '</thead>';
    }
}