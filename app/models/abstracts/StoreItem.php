<?php declare(strict_types=1);

namespace app\models\abstracts;

//define ('LOWEST_PRICE', 1);
//define ('HIGHEST_PRICE', 3);
//define ('DEFAULT_TAX_PERCENTAGE', 5);
//define ('MINIMUM_TAX_PERCENTAGE', 0);
//define  ('MAXIMUM_TAX_PERCENTAGE', 35);


use app\models\concretes\Pastry;
use Exception;

abstract class StoreItem extends Entity {

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
//        if ($quantity < 0) {
//            throw new Exception('The quantity cannot be less than zero.');
//        }
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
//        if ($amount < 0) {
//            throw new Exception('The amount must be greater than zero');
//        }
        if (abs($amount) > $this->quantity) {
            throw new Exception('The decrease amount cannot be greater than the current quantity in stock');
        }
        $this->quantity -= abs($amount);
    }

    /**
     * @throws Exception
     */
    public function increaseQuantity (int $amount): void {
//        if ($amount < 0) {
//            throw new Exception('Cannot increase by a negative number');
//        }
        $this->quantity += abs($amount);
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

    public static function quantitySelector (): string {
        $elem = '<label for ="quantity">Quantity to Order</label>'
            . '<select id="quantity" name="quantity" required>';
        for ($i = 1; $i <= MAX_QUANTITY_PER_ORDER; $i++) {
            $elem .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}