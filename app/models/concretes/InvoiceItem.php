<?php declare(strict_types=1);
namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\Product;
use app\models\collections\Reviews;
use Exception;

define ('PRODUCT_RESTOCK_THRESHOLD', 12);
define ('CUSTOMER_MAX_PRODUCT_PER_ORDER',12);
define ('PRODUCT_DEFAULT_RESTOCK_QUANTITY', 144);

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
        $this->quantity += abs($amount);
    }


    /**
     * @throws Exception
     */
    public function decreaseQuantity (int $amount): void {
        if (abs($amount) > $this->quantity) {
            throw new Exception('The decrease amount cannot be greater than the current quantity');
        }
        $this->quantity -= abs($amount);
    }

    public function getCost (): float {
        return $this->pastry->getPrice() * $this->quantity;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof InventoryItem)
            return  parent::equals($object)
                && $this->pastry->equals($object->getPastry())
                && $this->quantity === $object->getQuantity();
        return false;
    }

    public function samePastry ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof InventoryItem)
            return  parent::equals($object)
                && $this->pastry->equals($object->getPastry());
        return false;
    }


    public function transfer (int $quantity): InventoryItem {
        try {
            $this->decreaseQuantity($quantity);
        }
        catch (Exception $e) {
            echo $e;
        }
        return new InventoryItem($this->pastry, $quantity);
    }

    public function __toString (): string {
        return  $this->pastry . ': quantity:' . $this->quantity . ' cost:' . number_format($this->getCost(), 2);
    }

    public function toRow (
        int $imageWidth=DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        $elem = '<tr id="productRow_"' . $this->getId() . ' onclick="rowClickHandler(' . $this->getId() . ')">'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->pastry->getImgTag($imageWidth, $imageHeight) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>';
        if ($this->quantity <= RESTOCK_LEVEL) {
            $elem .= '<td>Only ' . $this->quantity . ' left order soon</td>';
        }
        $elem .= '</tr>';
        return $elem;
    }

    public function tableHeader (): string {
        $elem = '<table id="productTable_"' . $this->getId() . '">'
            . '<thead>'
            . '<tr>'
            . '<th>Id</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>';
        if ($this->quantity <= RESTOCK_LEVEL) {
            $elem .= '<th>Quantity</th>';
        }
        $elem .= '</tr></thead>';
        return $elem;
    }

    public function toTable (
        int $imageWidth=DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
        int $imageHeight=DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
    ): string {
        return $this->tableHeader() . $this->toRow($imageWidth, $imageHeight)  . '</tbody></table>';
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