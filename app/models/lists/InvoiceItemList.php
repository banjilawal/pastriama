<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\InvoiceItem;
use app\models\concretes\Pastry;
use Exception;

class InvoiceItemList extends Model {

    public const MINIMUM_TAX_PERCENTAGE = 0;
    public const MAXIMUM_TAX_PERCENTAGE = 35;
    public const DEFAULT_TAX_PERCENTAGE = 5;
    private array $items;


    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    /**
     * @return InvoiceItem|array
     */
    public function getItems (): InvoiceItem|array {
        return $this->items;
    }

    public function getNumberOfItems (): int {
        $totalItems = 0;
        foreach ($this->items as $id => $item) {
            $totalItems += $this->items[$id]->getQuantity();
        }
        return $totalItems;
    }

    public function getSubTotal (): float {
        $cost = 0.00;
        foreach ($this->items as $id => $item) {
            $cost += $this->items[$id]->getCost();
        }
        return $cost;
    }

    public function getTax (): float {
        return $this->getSubTotal() * self::DEFAULT_TAX_PERCENTAGE / 100;
    }

    public function getTotal (): float  {
        return $this->getSubTotal() + $this->getTax();
    }

    /**
     * @param InvoiceItemList $items
     */
    public function addItems (InvoiceItemList $items): void {
        foreach ($items as $id => $item) {
            $this->add($item);
        }
    }

    public function addItem (InvoiceItem $item): void {
        $id = $item->getId();
        if (array_key_exists($id, $this->items)) {
            $this->items[$id]->increaseQuantity($item->getQuantity());
        }
        else {
            $this->items[$id] = $item;
        }
    }

    /**
     * @param InvoiceItemList $items
     * @throws Exception
     */
    public function removeItems (InvoiceItemList $items): void {
        foreach ($items as $id => $item) {
            $this->remove($item);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (InvoiceItem $item): void {
        $id = $item->getId();
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($item->getPastry()->__toString() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->items[$id]);
    }

    /**
     * @throws Exception
     */
    public function increase (Pastry $pastry, int $quantity): void {
        $id = $pastry->getId();
        if (array_key_exists($id, $this->items)) {
            $this->items[$id]->increasQuantity($quantity);
        }
        else { $this->items[$pastry->getId()] = new InvoiceItem($pastry, $quantity); }
    }

    /**
     * @throws Exception
     */
    public function decrease (Pastry $pastry, int $quantity): void {
        $id = $pastry->getId();
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($pastry->getName() . ' does not exist in the invoice. Cannot be decreased');
        }
        if ($quantity < 1) {
            throw new Exception(
                $quantity
                . ' is below the minimum that can be removed. Delete '
                . $pastry->getName() . ' from your list instead'
            );
        }
        if ($quantity > $this->items[$id]->getQuantity) {
            throw new Exception(
                $quantity
                . ' exceeds the amount of  ' . $pastry->getName()
                . ' in the invoice. Remove from your invoice instead.'
            );
        }
        if ($this->items[$id]->getQuantiy() > 1) {
            $this->items[$id]->removeQuantity($quantity);
        }
        if ($this->items[$id]->getQuantiy() == 1) {
            unset($this->items[$id]);
        }
    }

    public function search (Pastry $pastry): ?InvoiceItem {
        if (array_key_exists($pastry->getId(), $this->items)) {
            return $this->items[$pastry->getId()];
        }
        return null;
    }

    public function __toString (): string {
        $string = '';
        foreach ($this->items as $id => $item) {
            $string .= $this->items[$id] . PHP_EOL;
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table class="invoice-item-table" name="invoice-item-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '<th>Quantity</th>'
            . '<th>Cost</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $id => $item) {
            $elem .= $this->items[$id]->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}