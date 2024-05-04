<?php declare(strict_types=1);
namespace app\models\concretes;

use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use DateTime;
use Exception;

class CartItem extends StoreItem {

    private DateTime $timestamp;


    /**
     * @param Product $product
     * @param int $quantity
     * @param DateTime $timestamp
     * @throws Exception
     */
    public function __construct (Product $product, int $quantity, DateTime $timestamp) {
        parent::__construct($product, $quantity);
        $this->timestamp = $timestamp;
    }

    public function getTimestamp (): DateTime {
        return $this->timestamp;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof CartItem)
            return  parent::equals($object) && $this->timestamp === $object->getTimestamp();
        return false;
    }

    public function __toString (): string {
        return parent::__toString() . ' submiited:' . $this->timestamp->format(DATE_FORMAT);
    }
}