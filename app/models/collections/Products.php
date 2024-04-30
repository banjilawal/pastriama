<?php declare(strict_types=1);

namespace app\models\collections;

use app\models\abstracts\Model;
use app\models\abstracts\Product;

use Exception;

class Products extends Model {
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): Product|array {
        return $this->items;
    }


    /**
     * @throws Exception
     */
    public function add (Product $Product): void {
        if (array_key_exists($Product->getId(), $this->items)) {
            throw new Exception($Product->getId() . ' is already in the list');
        }
        $this->items[$Product->getId()] = $Product;
    }

    /**
     * @throws Exception
     */
    public function remove (Product $Product): void {
        $id = $Product->getId();
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($Product->getName() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->items[$id]);
    }

    public function searchById (int $id): ?Product {
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }
        return null;
    }

    public function searchByName (string $name): ?Product {
        foreach ($this->items as $Product) {
            if ($Product->getName() === $name)
                return $Product;
        }
        return null;
    }

    public function contains (Product $product): bool {
        foreach ($this->items as $id => $item) {
            if ($item->equals($product)) {
                return true;
            }
        }
        return false;
    }

    public function comparePrice (Product $a, Product $b): float {
        return $a->getPrice() - $b->getPrice();
    }

    public function __toString  (): string {
        $string = 'Products' . PHP_EOL;
        foreach ($this->items as $id => $Product) {
            $string  .= $this->items[$id] . PHP_EOL;
        }
        return $string;
    }

    public function randomProduct (): Product { return $this->items[array_rand($this->items)]; }
}