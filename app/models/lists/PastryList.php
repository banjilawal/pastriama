<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\abstracts\StoreItem;
use App\models\concretes\Pastry;
use Exception;

class PastryList extends Model {
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): Pastry|array {
        return $this->items;
    }

    /**
     * @throws Exception
     */
    public function addPastries (PastryList $pastries): void {
        foreach ($pastries as $id => $pastry) {
            $this->add($pastry);
        }
    }

    /**
     * @throws Exception
     */
    public function add (Pastry $pastry): void {
        if (array_key_exists($pastry->getId(), $this->items)) {
            throw new Exception($pastry->getId() . ' is already in the list');
        }
        $this->items[$pastry->getId()] = $pastry;
    }

    /**
     * @throws Exception
     */
    public function removePastries (PastryList $pastries): void {
        foreach ($pastries as $id => $pastry) {
            $this->remove($pastry);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (Pastry $pastry): void {
        $id = $pastry->getId();
        if (!array_key_exists($id, $this->items)) {
            throw new Exception($pastry->getName() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->items[$id]);
    }

    public function search (string $name): ?Pastry {
        foreach ($this->items as $id => $pastry) {
            if ($this->items[$id]->getName() === $name)
                return $this->items[$id];
        }
        return null;
    }

    public function comparePrice (Pastry $a, Pastry $b): float {
        return $a->getPrice() - $b->getPrice();
    }


    public function __toString  (): string {
        $string = 'Pastries' . PHP_EOL;
        foreach ($this->items as $id => $pastry) {
            $string  .= $this->items[$id] . PHP_EOL;
        }
        return $string;
    }

    public function toTable (int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH, int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT): string {
        $elem ='<table class="pastry-table" id="pastry-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $id => $pastry) {
            $elem .= $this->items[$id]->toRow($imageWidth, $imageHeight);
        }
        $elem .= '</tbody></table>';
        return $elem;
    }

    public function toDashboard(int $imageWidth, int $imageHeight): string {
        $elem ='<table class="pastry-dashboard" id="pastry-dashboard">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $pastry) {
            $elem .= '<tr id="' . $pastry->getId() . ' onclick="rowClickHandler($row)">'
                . '<h3>' . $pastry->getName() . '</h3>'
                . $pastry->getImgTag($imageWidth, $imageHeight)
                . '<h4>' . $pastry->getPrice() . '</h4>'
                . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
}