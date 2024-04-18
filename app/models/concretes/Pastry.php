<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\StoreItem;
use app\models\lists\ReviewList;
use app\models\singletons\ReviewsCatalog;
use DateTime;
use Exception;

class Pastry extends StoreItem {

    public function __construct (
        int $id,
        string $name,
        string $description,
        string $imageName,
        float $price
    ) {
        parent::__construct (
            $id,
            $name,
            $description,
            $imageName,
            $price
        );
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Pastry) {
            return parent::equals($object);
        }
        return false;
    }

    public function __toString (): string {
        return $this->getId()
            . ' ' . $this->getName()
            . ' ' . number_format($this->getPrice(), 2)
            . ' ' . $this->getDescription();
    }

    /**
     * @throws Exception
     */
    public function getReviews (): ReviewList { //(ReviewList $reviews): ReviewList {
        return new ReviewList();
    }
}