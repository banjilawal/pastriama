<?php declare(strict_types=1);

namespace app\models\abstracts;

//define ('LOWEST_PRICE', 1);
//define ('HIGHEST_PRICE', 3);
//define ('DEFAULT_TAX_PERCENTAGE', 5);
//define ('MINIMUM_TAX_PERCENTAGE', 0);
//define  ('MAXIMUM_TAX_PERCENTAGE', 35);

use app\interfaces\adapters\GetId;
use app\interfaces\adapters\GetProduct;
use app\interfaces\adapters\DecreaseQuantity;
use app\interfaces\adapters\IncreaseQuantity;
use Exception;

abstract class StoreItem extends Entity implements IncreaseQuantity, DecreaseQuantity, GetId, GetProduct {

    private Product $product;
    private int $quantity;

    /**
     * @param Product $product
     * @param int $quantity
     * @throws Exception
     */
    public function __construct(
        Product $product,
        int $quantity
    ) {
        if ($quantity < 0) {
            throw new Exception('The product cannot have a negative quantity. StoreItem creation failed.');
        }
        parent::__construct ($product->getId());
        $this->product = $product;
        $this->quantity = abs($quantity);
    }

    public function getProduct (): Product {
        return $this->product;
    }
    public function getQuantity (): int {
        return $this->quantity;
    }

    /**
     * @throws Exception
     */
    public function decreaseQuantity (int $amount): void {
        if ($amount < 0) {
            throw new Exception('Negative numbers are not supported. Enter unsigned numbers only.');
        }
        if (abs($amount) - $this->quantity < 0) {
            throw new Exception('Attempting to remove more items than exist. Removal request failed');
        }
        $this->quantity -= $amount;
    }

    /**
     * @throws Exception
     */
    public function increaseQuantity (int $amount): void {
        if ($amount < 0) {
            throw new Exception('Negative numbers are not supported. Enter unsigned numbers only.');
        }
        $this->quantity += $amount;
    }

    public function getCost (): float {
        return $this->product->getPrice() * $this->quantity;
    }

    /**
     * @throws Exception
     */
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof StoreItem) {
            return parent::equals($object)
                && $this->product->equals($object->getProduct())
                && $this->quantity === $object->getQuantity();
        }
        return false;
    }

    public function __toString (): string {
        return parent::__toString()
            . ' ' . $this->product . ' quantity:' . $this->quantity;
    }
}