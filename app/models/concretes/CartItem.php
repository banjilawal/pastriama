<?php declare(strict_types=1);
namespace app\models\concretes;

use app\interfaces\Quantifiable;
use app\models\abstracts\Entity;
use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use app\models\collections\Reviews;
use DateTime;
use Exception;

class CartItem extends StoreItem {

    private DateTime $additionTime;


    /**
     * @param Product $product
     * @param int $quantity
     * @param DateTime $additionTime
     * @throws Exception
     */
    public function __construct (Product $product, int $quantity, DateTime $additionTime) {
        parent::__construct($product, $quantity);
        $this->additionTime = $additionTime;
    }

    public function getAdditionTime (): DateTime {
        return $this->additionTime;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof CartItem)
            return  parent::equals($object) && $this->additionTime === $object->getAdditionTime();
        return false;
    }

    public function __toString (): string {
        return parent::__toString() . ' added on ' . $this->additionTime->format(DATE_FORMAT);
    }
}