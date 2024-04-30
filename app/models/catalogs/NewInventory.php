<?php declare(strict_types=1);

namespace app\models\catalogs;

use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\abstracts\StoreItem;
use app\models\concretes\CartItem;
use app\models\concretes\InventoryItem;
use App\Models\Concretes\NewOrder;
use app\models\concretes\Pastry;
use App\Models\Concretes\User;
use app\models\collections\InvoiceItems;
use App\Models\collections\Orders;
use app\models\collections\Pastries;
use DateTime;
use Exception;

class NewInventory extends Model {
    private static $instance;
    protected array $items;

    private function __construct () {
        parent::__construct();
        $this->items = array ();
    }

    public static function getInstance (): NewInventory {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __clone () {}
    public function __wakeup () {}

    public function getItems (): InventoryItem|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function add (Product $product, int $amount): void {
//        if ($amount < 0) {
//            throw new Exception('Cannot add less than zero items of ' . $product->getName() . ' to the inventory.');
//        }
        $id = $product->getId();
        if ($this->contains($product)) {
            $this->items[$id]->increaseQuantity($amount);
        } else { $this->items[$id] = new InventoryItem($product, $amount); }
    }

    /**
     * @throws Exception
     */
    public function remove (Product $product, int $amount): InventoryItem {
        if (!$this->amountExists($product, $amount)) {
            throw new Exception ('There is an insufficient amount of ' . $product . ' to meet the request');
        }
        $id = $product->getId();
        $this->items[$id]->decreaseQuantity($amount);
        if ($this->items[$id]->getQuantity() <= RESTOCK_LEVEL) {
            $this->items[$id]->increaseQuantity(DEFAULT_RESTOCK_QUANTITY);
        }
        return new InventoryItem($product, $amount);
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
        $string = 'Inventory' . PHP_EOL;
        foreach ($this->items as $item) {
            $string .= $item . PHP_EOL;
        }
        return $string;
    }

    public function random (): InventoryItem {
        return $this->items[array_rand($this->items)];
    }
}