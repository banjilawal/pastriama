<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\Product;
use app\models\concretes\Pastry;
use app\models\catalogs\Inventory;
use Exception;

class Products extends Model {

    public const MINIMUM_QUANTITY = 5;
    public const MINIMUM_TAX_PERCENTAGE = 0;
    public const MAXIMUM_TAX_PERCENTAGE = 35;
    public const DEFAULT_TAX_PERCENTAGE = 5;
    private array $list;


    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    /**
     * @return Product|array
     */
    public function getList (): Product|array {
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
    public function add (Pastry $pastry, int $quantity): void {
        if ($quantity <= 0) {
            throw new \Exception('Cannot add ' . $quantity . ' of ' . $pastry->getName() . ' to the list.');
        }
        $product = $this->searchByPastry($pastry);
        if (!is_null($product)) {
            $this->list[$product->getId()]->increaseQuantity($quantity);
        }
        $product = new Product($pastry, $quantity);
        $this->list[$product->getId()] = $product;
    }

    /**
     * @param Products $products
     */
    public function addProducts (Products $products): void {
        foreach ($products as $item) {
            $this->addProduct($item);
        }
    }

    public function addProduct (Product $product): void {
        $id = $product->getId();
        if (array_key_exists($id, $this->list)) {
            $this->list[$id]->increaseQuantity($product->getQuantity());
        }
        else {
            $this->list[$id] = $product;
        }
    }

    /**
     * @param Products $items
     * @throws Exception
     */
    public function removeItems (Products $items): void {
        foreach ($items as $id => $item) {
            $this->remove($item);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (Product $item): void {
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
        else { $this->list[$pastry->getId()] = new Product($pastry, $quantity); }
    }

    /**
     * @throws Exception
     */
    public function transferProductTo (Products $destination, Pastry $pastry, int $quantity): void {
        $product = $this->searchByPastry($pastry);
        if (is_null($product)) {
            throw new Exception($pastry->getName() . ' is not in the list. Cannot transfer to destination.');
        }
        $destination->addProduct($product);
    }

    /**
     * @throws Exception
     */
    public function emptyToTarget (Products $target): void {
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
    public function getFromSource (Products $source, Product $product): void {
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

    public function searchById (int $id): ?Product {
        if (array_key_exists($id, $this->list)) {
            return $this->list[$id];
        }
        return null;
    }

    public function searchByProduct (Product $product): ?Product {
        return $this->searchById($product->getId());
    }

    public function contains (Product $product): bool {
        return (array_key_exists($product->getId(), $this->list));
    }

    public function searchByPastry (Pastry $pastry): ?Product {
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

//    public function randomItem (): Product {
////        $index = array_rand(array_keys($this->products));
//        $key = array_keys($this->list)[array_rand(array_keys($this->list))];
//        if ($this->list[$key]->getQuantity() <= Products::MINIMUM_QUANTITY) {
//            $this->list[$key]->increaseQuantity(Products::MINIMUM_QUANTITY * 20);
//        }
//        $quantity = rand(1, (Products::MINIMUM_QUANTITY * 2));
//        $this->list[$key]->decreaseQuantity($quantity);
//        return new Product($this->list[$key]->getPastry(), $quantity);
//    }

    public function toTable (): string {
        $elem = '<table id="invoiceTable">'
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
            . '</thead>'
            . '<tbody>';
        foreach ($this->list as $id => $item) {
            $elem .= $this->list[$id]->toRow();
        }
//            $elem .= '<tr onclick="send(' . $id . ')">'
//                . '<td>' . $id . '</td>'
//                . '<td>' . $item->getPastry()->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
//                . '<td>' . $item->getPastry()->getName() . '</td>'
//                . '<td>' . $item->getPastry()->getDescription() . '</td>'
//                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
//                . '<td>' .  '</td>'
//                . '<td>' . $pastry->getReveiws(
//                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
//                )->getAverageRating() . '</td>'
//                . '</tr>';
//        }
        $elem .= '</tbody></table>';
        return $elem;
//        foreach ($this->items as $item) {
////            echo $item . '<br>' . PHP_EOL;
//            $elem .= $item->toRow();
//        }
//        $elem .= '<tr><td>Tax</td><td>' . number_format($this->getTax(), 2) . '</td></tr>'
//            . '<tr><td>Total</td><td>' . number_format($this->getTotalCharge(), 2)  . '</td></tr>'
//            . '</tbody></table>';
//        return $elem;
    }

    public function randomProduct (): Product {
        return $this->list[array_rand($this->list)];
    }
}