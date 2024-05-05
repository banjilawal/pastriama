<?php declare(strict_types=1);

namespace app\models\collections;

use app\models\abstracts\Aggregation;
use app\models\abstracts\Model;
use app\models\abstracts\Product;
use app\models\catalogs\Inventory;
use app\models\concretes\CartItem;
use app\models\concretes\OrderItem;
use app\models\concretes\Pastry;

use Exception;

class OrderItems extends Aggregation {
    private array $list;


    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    /**
     * @return OrderItem|array
     */
    public function getList (): OrderItem|array {
        return $this->list;
    }

    public function getNumberOfItems (): int {
        $totalItems = 0;
        foreach ($this->list as $item) {
            $totalItems += $item->getQuantity();
        }
        return $totalItems;
    }

    public function getSubTotal (): float {
        $subTotal = 0.00;
        foreach ($this->list as $product) {
            $subTotal += $product->getCost();
        }
        return $subTotal;
    }

    public function getTax (): float {
        return $this->getSubTotal() * DEFAULT_TAX_PERCENTAGE / 100;
    }

    public function getTotalCharge (): float  {
        return $this->getSubTotal() + $this->getTax();
    }

    /**
     * @throws Exception
     */
    public function add (Product $product, int $quantity): void {
        if ($quantity <= 0) {
            throw new Exception('Cannot add ' . $quantity . ' of ' . $product->getName() . ' to the list.');
        }
        $item = null;
        try {
            $item = Inventory::getInstance()->putInCart($product, $quantity);
        } catch(Exception $e) {
            echo $e;
        }
        $id = $item->getId();
        if (array_key_exists($id, $this->list)) {
            $this->list[$id]->increaseQuantity($quantity);
        } else {
            $this->list[$id] = new CartItem($item->getProduct(), $item->getQuantity());;
        }
    }

    /**
     * @param InvoiceItems $products
     */
    public function addProducts (OrderItems $products): void {
        foreach ($products as $item) {
            $this->addProduct($item);
        }
    }

    public function addProduct (OrderItem $product): void {
        $id = $product->getId();
        if (array_key_exists($id, $this->list)) {
            $this->list[$id]->increaseQuantity($product->getQuantity());
        }
        else {
            $this->list[$id] = $product;
        }
    }

    /**
     * @param InvoiceItems $items
     * @throws Exception
     */
    public function removeItems (OrderItems $items): void {
        foreach ($items as $id => $item) {
            $this->remove($item);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (OrderItem $item): void {
        $id = $item->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($item->getPastry()->__toString()
                . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->list[$id]);
    }

    /**
     * @throws Exception
     */
    public function increase (Pastry $pastry, int $quantity): void {
        $id = $pastry->getId();
        if (array_key_exists($id, $this->list)) {
            $this->list[$id]->increasQuantity($quantity);
        }
        else { $this->list[$pastry->getId()] = new OrderItem($pastry, $quantity); }
    }

    /**
     * @throws Exception
     */
    public function transferProductTo (OrderItems $destination, Pastry $pastry, int $quantity): void {
        $product = $this->searchByPastry($pastry);
        if (is_null($product)) {
            throw new Exception($pastry->getName() . ' is not in the list. Cannot transfer to destination.');
        }
        $destination->addProduct($product);
    }

    /**
     * @throws Exception
     */
    public function emptyToTarget (OrderItems $target): void {
        foreach ($this->list as $product) {
            $target->getFromSource($this, $product);
        }
//        foreach($this->list as $id => $item) {
//            $target->addProduct($this->list[$id]);
//            unset($this->list[$id]);
//        }
    }

    /**
     * @throws Exception
     */
    public function getFromSource (OrderItems $source, OrderItem $product): void {
        $id = $product->getId();
        if (!array_key_exists($id, $source->getList())) {
            throw new Exception('The product does not exist in the source so it cannot be transferred.');
        }
        $this->addProduct($source->getList()[$id]);
        unset($source->getList()[$id]);
    }

    /**
     * @throws Exception
     */
    public function decrease (Pastry $pastry, int $quantity): void {
        $id = $pastry->getId();
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($pastry->getName() . ' does not exist in the invoice. Cannot be decreased');
        }
        if ($quantity < 1) {
            throw new Exception(
                $quantity
                . ' is below the minimum that can be removed. Delete '
                . $pastry->getName() . ' from your list instead'
            );
        }
        if ($quantity > $this->list[$id]->getQuantity) {
            throw new Exception(
                $quantity
                . ' exceeds the amount of  ' . $pastry->getName()
                . ' in the invoice. Remove from your invoice instead.'
            );
        }
        if ($this->list[$id]->getQuantiy() > 1) {
            $this->list[$id]->removeQuantity($quantity);
        }
        if ($this->list[$id]->getQuantiy() == 1) {
            unset($this->list[$id]);
        }
    }

    public function searchById (int $id): ?OrderItem {
        if (array_key_exists($id, $this->list)) {
            return $this->list[$id];
        }
        return null;
    }

    public function searchByProduct (OrderItem $product): ?OrderItem {
        return $this->searchById($product->getId());
    }

    public function contains (OrderItem $product): bool {
        return (array_key_exists($product->getId(), $this->list));
    }

    public function searchByPastry (Pastry $pastry): ?OrderItem {
        foreach ($this->list as $id => $product) {
            if ($product->getPastry()->equals($pastry))
                return $this->list[$id];
        }
        return null;
    }

    public function __toString (): string {
        $string = ''; //$this->items
        foreach ($this->list as $item) {
            $string .= $item . PHP_EOL;
        };
        $string .= 'subtotal:' . number_format($this->getSubTotal() , 2)
            . ' tax:' . number_format($this->getTax() , 2)
            . ' total:' . number_format($this->getTotalCharge(), 2);
        return $string;
    }

//    public function randomItem (): InvoiceItem {
////        $index = array_rand(array_keys($this->products));
//        $key = array_keys($this->list)[array_rand(array_keys($this->list))];
//        if ($this->list[$key]->getQuantity() <= InvoiceItems::MINIMUM_QUANTITY) {
//            $this->list[$key]->increaseQuantity(InvoiceItems::MINIMUM_QUANTITY * 20);
//        }
//        $quantity = rand(1, (InvoiceItems::MINIMUM_QUANTITY * 2));
//        $this->list[$key]->decreaseQuantity($quantity);
//        return new InvoiceItem($this->list[$key]->getPastry(), $quantity);
//    }

    public function tableHeader (): string {
        return '<table>'
            . '<thead>'
            . '<tr>'
            . '<th>ID</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '<th>Quantity</th>'
            . '<th>Cost</th>'
            . '</tr>'
            . '</thead>';
    }

    public function toTable (): string {
        $elem = self::tableHeader() . '<tbody>';
        foreach ($this->list as $id => $product) {
            $elem = '<tr id="productId_"' . $id . ' onclick="rowClickHandler(' . $id . ')">'
                . '<td>' . $id . '</td>'
                . '<td>' . $product->getPastry()->getImgTag() . '</td>'
                . '<td>' . $product->getPastry()->getName() . '</td>'
                . '<td>' . $product->getPastry()->getDescription() . '</td>'
                . '<td>' . number_format($product->getPastry()->getPrice(), 2) . '</td>'
                . '<td>' . $product->getQuantity() . '</td>'
                . '<td>' . number_format($product->getCost(), 2) . '</td>'
                . '</tr>';
        }
        return $elem . '</tbody></table>';
    }

    public function random (): OrderItem {
        return $this->list[array_rand($this->list)];
    }
}