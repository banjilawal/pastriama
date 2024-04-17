<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\abstracts\StoreItem;
use App\models\concretes\Pastry;
use DateTime;
use Exception;

class Pastries extends Model {
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
    public function addPastries (Pastries $pastries): void {
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
    public function removePastries (Pastries $pastries): void {
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

    public function searchById (int $id): ?Pastry {
        if (array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }
        return null;
    }

    public function searchByName (string $name): ?Pastry {
        foreach ($this->items as $pastry) {
            if ($pastry->getName() === $name)
                return $pastry;
        }
        return null;
    }

    public function comparePrice (Pastry $a, Pastry $b): float {
        return $a->getPrice() - $b->getPrice();
    }


    public function __toString  (): string {
        $string = nl2br('Pastries' . PHP_EOL);
        foreach ($this->items as $id => $pastry) {
            $string  .= $this->items[$id] . PHP_EOL;
        }
        return $string;
    }

    public function toTable (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        $elem ='<table id="pastryTable">'
            . '<thead>'
            . '<tr>'
                . '<th>Id</th>'
                . '<th>Picture</th>'
                . '<th>Name</th>'
                . '<th>Description</th>'
                . '<th>Price</th>'
//                . '<th>Average Rating</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->items as $id => $pastry) {
            $elem .= '<tr onclick="send(' . $pastry->getId() . ')">'
                . '<td>' . $id . '</td>'
                . '<td>' . $pastry->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
                . '<td>' . $pastry->getName() . '</td>'
                . '<td>' . $pastry->getDescription() . '</td>'
                . '<td>' . number_format($pastry->getPrice(), 2) . '</td>'
//                . '<td>' . $pastry->getReveiws(
//                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
//                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
//                )->getAverageRating() . '</td>'
                . '</tr>';
        }
        $elem .= '</tbody></table>';
        return $elem;
    }

    public function toDashboard(
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
    ): string {
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