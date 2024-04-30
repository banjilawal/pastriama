<?php

namespace app\models\concretes;

use app\enums\Rating;
use app\models\abstracts\Entity;

use app\models\abstracts\Product;
use DateTime;
use Exception;

class NewReview extends Entity {

    private NewUser $user;
    private Product $product;
    private Rating $rating;
    private string $title;
    private string $comment;
    private DateTime $submissionTime;

    /**
     * @throws Exception
     */
    public function __construct(
        int $id,
        NewUser $user,
        Product $product,
        Rating $rating,
        string $title,
        string $comment,
        DateTime $submissionTime
    ) {
        parent::__construct($id);
        $this->user = $user;
        $this->product = $product;
        $this->rating = $rating;
        $this->title = $title;
        $this->comment = $comment;
        $this->submissionTime = $submissionTime;
    }

    public function getUser (): NewUser {
        return $this->user;
    }

    public function getProduct (): Product {
        echo nl2br('Review has product:-->' . $this->product->getName() . PHP_EOL);
        return $this->product;
    }

    public function getRating (): Rating {
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
            . ' product:' . $this->product
            . ' submitted:' . $this->submissionTime->format(DATE_FORMAT)
            . ' reviewer:' . $this->user->printName()
            . ' title:' . $this->title
            . ' rating:' . $this->rating->name
            . ' comment:' . $this->comment;
    }
}