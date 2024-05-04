<?php

namespace app\models\concretes;

use app\enums\Rating;
use app\models\abstracts\Entity;

use app\models\abstracts\Product;
use DateTime;
use Exception;

class review extends Entity {

    private User $user;
    private Product $product;
    private Rating $rating;
    private string $title;
    private string $comment;
    private DateTime $timestamp;

    /**
     * @param int $id
     * @param User $user
     * @param Product $product
     * @param Rating $rating
     * @param string $title
     * @param string $comment
     * @param DateTime $timestamp
     */
    public function __construct (
        int $id,
        User $user,
        Product $product,
        Rating $rating,
        string $title,
        string $comment,
        DateTime $timestamp
    ) {
        parent::__construct($id);
        $this->user = $user;
        $this->product = $product;
        $this->rating = $rating;
        $this->title = $title;
        $this->comment = $comment;
        $this->timestamp = $timestamp;
    }


    public function getUser (): User {
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

    public function getTimestamp (): DateTime {
        return $this->timestamp;
    }


    /**
     * @throws Exception
     */
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof review) {
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
            . ' submitted:' . $this->timestamp->format(DATE_FORMAT)
            . ' reviewer:' . $this->user->printName()
            . ' title:' . $this->title
            . ' rating:' . $this->rating->name
            . ' comment:' . $this->comment;
    }
}