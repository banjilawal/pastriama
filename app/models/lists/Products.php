<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\InventoryItem;
use app\models\concretes\Pastry;
use app\models\singletons\Inventory;
use Exception;

class Products extends Model {

    public const MINIMUM_QUANTITY = 5;
    public const MINIMUM_TAX_PERCENTAGE = 0;
    public const MAXIMUM_TAX_PERCENTAGE = 35;
    public const DEFAULT_TAX_PERCENTAGE = 5;
    private array $products;


    public function __construct () {
        parent::__construct();
        $this->products = array();
    }

    /**
     * @return InventoryItem|array
     */
    public function getProducts (): InventoryItem|array {
        return $this->products;
    }

    public function getNumberOfItems (): int {
        $totalItems = 0;
        foreach ($this->products as $item) {
            $totalItems += $item->getQuantity();
        }
        return $totalItems;
    }

    public function getSubTotal (): float {
        $subTotal = 0.00;
        foreach ($this->products as $item) {
            $subTotal += $item->getCost();
        }
        return $subTotal;
    }

    public function getTax (): float {
        return $this->getSubTotal() * self::DEFAULT_TAX_PERCENTAGE / 100;
    }

    public function getTotalCharge (): float  {
        return $this->getSubTotal() + $this->getTax();
    }

    /**
     * @param Products $items
     */
    public function addItems (Products $items): void {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add (InventoryItem $item): void {
        $id = $item->getId();
        if (array_key_exists($id, $this->products)) {
            $this->products[$id]->increaseQuantity($item->getQuantity());
        }
        else {
            $this->products[$id] = $item;
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
    public function remove (InventoryItem $item): void {
        $id = $item->getId();
        if (!array_key_exists($id, $this->products)) {
            throw new Exception($item->getPastry()->__toString() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->products[$id]);
    }

    /**
     * @throws Exception
     */
    public function increase (Pastry $pastry, int $quantity): void {
        $id = $pastry->getId();
        if (array_key_exists($id, $this->products)) {
            $this->products[$id]->increasQuantity($quantity);
        }
        else { $this->products[$pastry->getId()] = new InventoryItem($pastry, $quantity); }
    }

    public function transferToTarget (Products $target): void {
        foreach($this->products as $id => $item) {
            $target->add($this->products[$id]);
            unset($this->products[$id]);
        }
    }

    /**
     * @throws Exception
     */
    public function decrease (Pastry $pastry, int $quantity): void {
        $id = $pastry->getId();
        if (!array_key_exists($id, $this->products)) {
            throw new Exception($pastry->getName() . ' does not exist in the invoice. Cannot be decreased');
        }
        if ($quantity < 1) {
            throw new Exception(
                $quantity
                . ' is below the minimum that can be removed. Delete '
                . $pastry->getName() . ' from your list instead'
            );
        }
        if ($quantity > $this->products[$id]->getQuantity) {
            throw new Exception(
                $quantity
                . ' exceeds the amount of  ' . $pastry->getName()
                . ' in the invoice. Remove from your invoice instead.'
            );
        }
        if ($this->products[$id]->getQuantiy() > 1) {
            $this->products[$id]->removeQuantity($quantity);
        }
        if ($this->products[$id]->getQuantiy() == 1) {
            unset($this->products[$id]);
        }
    }

    public function searchById (int $id): ?InventoryItem {
        if (array_key_exists($id, $this->products)) {
            return $this->products[$id];
        }
        return null;
    }

    public function searchByPastry (Pastry $pastry): ?InventoryItem {
        if (array_key_exists($pastry->getId(), $this->products)) {
            return $this->products[$pastry->getId()];
        }
        return null;
    }

    public function searchByName (string $pastryName): ?InventoryItem {
        foreach ($this->products as $item) {
            if ($item->getPastry()->getName === $pastryName)
                return $item;
        }
        return null;
    }

    public function __toString (): string {
        $string = ''; //$this->items
        foreach ($this->products as $item) {
            $string .= $item . PHP_EOL;
        };
        $string .= 'subtotal:' . number_format($this->getSubTotal() , 2)
            . ' tax:' . number_format($this->getTax() , 2)
            . ' total:' . number_format($this->getTotalCharge(), 2);
        return $string;
    }

    public function randomItem (): InventoryItem {
//        $index = array_rand(array_keys($this->products));
        $key = array_keys($this->products)[array_rand(array_keys($this->products))];
        if ($this->products[$key]->getQuantity() <= Products::MINIMUM_QUANTITY) {
            $this->products[$key]->increaseQuantity(Products::MINIMUM_QUANTITY * 20);
        }
        $quantity = rand(1, (Products::MINIMUM_QUANTITY * 2));
        $this->products[$key]->decreaseQuantity($quantity);
        return new InventoryItem($this->products[$key]->getPastry(), $quantity);
    }

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
        foreach ($this->products as $id => $item) {
            $elem .= '<tr onclick="send(' . $id . ')">'
                . '<td>' . $id . '</td>'
                . '<td>' . $item->getPastry()->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
                . '<td>' . $item->getPastry()->getName() . '</td>'
                . '<td>' . $item->getPastry()->getDescription() . '</td>'
                . '<td>' . number_format($item->getPastry()->getPrice(), 2) . '</td>'
                . '<td>' .  '</td>'
//                . '<td>' . $pastry->getReveiws(
//                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
//                )->getAverageRating() . '</td>'
                . '</tr>';
        }
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


}