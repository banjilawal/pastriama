<?php declare(strict_types=1);
namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\StoreItem;
use Exception;
use const app\oldpages\PASTRY_IMAGE_HEIGHT;
use const app\oldpages\PASTRY_IMAGE_WIDTH;

class InvoiceItem extends Entity {
    private Pastry $pastry;
    private int $quantity;

    /**
     * @param Pastry $pastry
     * @param int $quantity
     */
    public function __construct (Pastry $pastry, int $quantity) {
        parent::__construct($pastry->getId());
        $this->pastry = $pastry;
        $this->quantity = $quantity;
    }

    public function getPastry (): Pastry {
        return $this->pastry;
    }

    public function getQuantity (): int {
        return $this->quantity;
    }

    public function setPastry (Pastry $pastry): void {
        $this->pastry = $pastry;
    }

//    /**
//     * @throws \Exception
//     */
//    public function setQuantity (int $quantity): void {
//        if ($quantity <= 0) {
//            throw new \Exception('Cannot set the amount of ' . $this->pastry->getName() . ' to zero or less ' );
//        }
//        $this->quantity = $quantity;
//    }

    /**
     * @throws Exception
     */
    public function increaseQuantity (int $amount): void {
        if ($amount < 0) {
            throw new Exception('Cannot increase by a negative number');
        }
        $this->quantity += $amount;
    }


    /**
     * @throws Exception
     */
    public function decreaseQuantity (int $amount): void {
        if (abs($amount) > $this->quantity) {
            throw new Exception('The decrease amount cannot be greater than the current quantity');
        }
        $this->quantity -= $amount;
    }

    public function getCost (): float {
        return $this->pastry->getPrice() * $this->quantity;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof InvoiceItem)
            return  parent::equals($object)
                && $this->pastry->equals($object->getPastry())
                && $this->quantity === $object->getQuantity();
        return false;
    }

    public function __toString (): string {
        return  'InvoiceItem_toString( ' . parent::__toString()
            . ': quantity:' . $this->quantity
            . ' ' . $this->pastry . ' cost:' . number_format($this->getCost(), 2) . ')';
    }

    public function toRow (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        return '<tr class="invoice-item-row" id="invoice-item-row">' // name="invoice-item-row">'
            . '<td hidden>' . $this->pastry->getId() . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getImgTag($imageWidth, $imageHeight) . '</td>'
//            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . number_format($this->pastry->getPrice(), 2) . '</td>'
            . '<td>' . $this->quantity . '</td>'
            . '<td>' . number_format($this->getCost(), 2) . '</td>'
            . '</tr>';
    }

    public function toTable (): string {
        return '<table class="invoice-item-table" id="invoice-item-table" name="invoice-item-table">'
            . '<thead>'
            . '<tr>'
//            . '<th>Picture</th>'
            . '<th>Name</th>'
//            . '<th>Description</th>'
            . '<th>Price</th>'
            . '<th>Quantity</th>'
            . '<th>Cost</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
//            . '<td>' . $this->pastry->getImgTag($imageWidth, $imageHeight) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
//            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '<td>' . $this->quantity . '</td>'
            . '<td>' . number_format($this->getCost(), 2) . '</td>'
            . '</tbody>'
            . '</table>';
    }

    public static function quantitySelector (): string {
        $maxQuantity = 10;
        $elem = '<label for ="quantity">Quantity to Order</label>'
            . '<select id="quantity" name="quantity" required>';
        for ($i = 1; $i <= $maxQuantity; $i++) {
            $elem .= '<option value="' . $i . '">' . $i . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}