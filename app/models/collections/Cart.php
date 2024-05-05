<?php declare(strict_types=1);

namespace app\models\collections;

use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use app\models\catalogs\Inventory;
use app\models\concretes\CartItem;
use app\models\concretes\InventoryItem;
use app\models\concretes\Pastry;

use DateTime;
use Exception;

class Cart extends Aggregation {

    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    /**
     * @return CartItem|array
     */
    public function getItems (): CartItem|array {
        return $this->items;
    }

    public function getNumberOfItems (): int {
        $totalItems = 0;
        foreach ($this->items as $item) {
            $totalItems += $item->getQuantity();
        }
        return $totalItems;
    }

    public function getSubTotal (): float {
        $subTotal = 0.00;
        foreach ($this->items as $item) {
            $subTotal += $item->getCost();
        }
        return $subTotal;
    }

    /**
     * @throws Exception
     */
    public function add (StoreItem $storeItem, DateTime $additionTime): void {
        $id = $storeItem->getId();
        $product = $storeItem->getProduct();
        $amount = $storeItem->getQuantity();
        if ($this->contains($product)) {
            $this->items[$id]->increaseQuantity($amount);
        }
        else {
            $this->items[$id] = new CartItem($product, $amount, $additionTime);
        }
//        try {
//            $item = Inventory::getInstance()->remove($product, $amount);
//        } catch (Exception $e) { echo $e; }
//        if ($this->contains($product)) {
//            $this->items[$id]->increaseQuantity($amount);
//        } else {
//            try {
//                $this->items[$id] = new CartItem($product, $amount, $additionTime);
//            } catch (Exception $e) { echo $e; }
//        }
    }

    /**
     * @throws Exception
     */
    public function remove (Product $product, int $amount): CartItem {
        if (!$this->amountExists($product, $amount)) {
            throw new Exception ('There is an insufficient amount of ' . $product . ' to meet the request');
        }
        $id = $product->getId();
        $this->items[$id]->decreaseQuantity($amount);
        if ($this->items[$id]->getQuantity() <= 0) {
           unset( $this->items[$id]);
        }
        return new CartItem($product, $amount, new DateTime());
    }

    public function searchByName (string $name): ?InventoryItem {
        foreach ($this->items as $id => $item) {
            if ($this->items[$id]->getProduct()->getName() === $name) {
                return $this->items[$id];
            }
        }
        return null;
    }

    public function searchByProduct (Product $product): ?InventoryItem {
        foreach ($this->items as $id => $item) {
            if ($this->items[$id]->getProduct()->equals($product)) {
                return $this->items[$id];
            }
        }
        return null;
    }

    public function searchById (int $id): ?InventoryItem {
        if (array_key_exists($id, $this->items))
            return $this->items[$id];
        return null;
    }

    public function contains (Product $product): bool {
        return (array_key_exists($product->getId(), $this->items));
    }

    public function amountExists (Product $product, int $amount): bool {
        $id = $product->getId();
        return array_key_exists($id, $this->items) && $this->items[$id]->getQuantity() >= $amount;
    }

    public function getQuantity (Product $product): int {
        if (!$this->contains($product))
            return PHP_INT_MIN;
        else
            return $this->items[$product->getId()]->getQuantity();
    }

    public function __toString (): string {
        $string = 'Cart' . PHP_EOL;
        foreach ($this->items as $item) {
            $string .= $item . PHP_EOL;
        }
        return $string;
    }
    public function random (): CartItem {
        return $this->items[array_rand($this->items)];
    }
}