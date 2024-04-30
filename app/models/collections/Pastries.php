<?php declare(strict_types=1);

namespace app\models\collections;

use app\models\abstracts\Model;
use app\models\abstracts\Product;
use App\models\concretes\Pastry;

use Exception;

class Pastries extends Model {
    private array $list;

    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): Pastry|array {
        return $this->list;
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
        if (array_key_exists($pastry->getId(), $this->list)) {
            throw new Exception($pastry->getId() . ' is already in the list');
        }
        $this->list[$pastry->getId()] = $pastry;
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
        if (!array_key_exists($id, $this->list)) {
            throw new Exception($pastry->getName() . ' does not exist in order. Cannot remove nonexistent item');
        }
        unset($this->list[$id]);
    }

    public function searchById (int $id): ?Pastry {
        if (array_key_exists($id, $this->list)) {
            return $this->list[$id];
        }
        return null;
    }

    public function searchByName (string $name): ?Pastry {
        foreach ($this->list as $pastry) {
            if ($pastry->getName() === $name)
                return $pastry;
        }
        return null;
    }

    public function contains (Pastry $pastry): bool {
        return array_key_exists($pastry->getId(), $this->list);
    }

    public function comparePrice (Pastry $a, Pastry $b): float {
        return $a->getPrice() - $b->getPrice();
    }

    public function __toString  (): string {
        $string = nl2br('Pastries' . PHP_EOL);
        foreach ($this->list as $id => $pastry) {
            $string  .= $this->list[$id] . PHP_EOL;
        }
        return $string;
    }

    public function tableHeader(): string {
        return '<thead>'
            . '<tr>'
            . '<th>Id</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '<th>Average Rating</th>'
            . '</tr>'
            . '</thead>';
    }

    /**
     * @throws Exception
     */
    public function tableBody (Reviews $reviewsCatalog, int $imageWidth, int $imageHeight): string {
        $elem = '<tbody>';
        foreach ($this->list as $id => $pastry) {
            $elem .= '<tr id=pastryId_"' . $id . ' onclick="rowClickHandler(' . $id  . ')">'
                . '<td>' . $id . '</td>'
                . '<td>' . $pastry->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
                . '<td>' . $pastry->getName() . '</td>'
                . '<td>' . $pastry->getDescription() . '</td>'
                . '<td>' . number_format($pastry->getPrice(), 2) . '</td>';
            $reviews = $reviewsCatalog->filterByPastry($pastry);
            $elem .= '<td>' . $reviews->getAverageRating() . ' stars for ' . count($reviews->getList()) . ' reviews</td>'
                . '</tr>';
        }
        return $elem . '<tbody>';
    }

    /**
     * @throws Exception
     */
    public function toTable (
        Reviews $reviews,
        int $imageWidth=DEFAULT_ROW_IMAGE_WIDTH,
        int $imageHeight=DEFAULT_ROW_IMAGE_HEIGHT
    ): string {
        return '<table>' . $this->tableHeader() . $this->tableBody($reviews, $imageWidth, $imageHeight) . '</table>';
    }

//    public function toTable (
//
//        int $imageWidth=Product::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
//        int $imageHeight=Product::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
//    ): string {
//        $elem ='<table id="pastryTable">'
//            . '<thead>'
//            . '<tr>'
//                . '<th>Id</th>'
//                . '<th>Picture</th>'
//                . '<th>Name</th>'
//                . '<th>Description</th>'
//                . '<th>Price</th>'
////                . '<th>Average Rating</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//        foreach ($this->list as $id => $pastry) {
//            $elem .= '<tr onclick="rowClickHandler(' . $pastry->getId() . ')">'
//                . '<td>' . $id . '</td>'
//                . '<td>' . $pastry->getImgTag() . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
//                . '<td>' . $pastry->getName() . '</td>'
//                . '<td>' . $pastry->getDescription() . '</td>'
//                . '<td>' . number_format($pastry->getPrice(), 2) . '</td>'
////                . '<td>' . $pastry->getReveiws(
////                    DateTime::createFromFormat('Y-m-d', '2020-01-01'),
////                    DateTime::createFromFormat('Y-m-d', '2029-01-01')
////                )->getAverageRating() . '</td>'
//                . '</tr>';
//        }
//        $elem .= '</tbody></table>';
//        return $elem;
//    }

//    public function toDashboard(
//        int $imageWidth=Product::DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
//        int $imageHeight=Product::DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
//    ): string {
//        $elem ='<table class="pastry-dashboard" id="pastry-dashboard">'
//            . '<thead>'
//            . '<tr>'
//            . '<th>Picture</th>'
//            . '<th>Name</th>'
//            . '<th>Description</th>'
//            . '<th>Price</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//        foreach ($this->list as $pastry) {
//            $elem .= '<tr id="' . $pastry->getId() . ' onclick="rowClickHandler($row)">'
//                . '<h3>' . $pastry->getName() . '</h3>'
//                . $pastry->getImgTag($imageWidth, $imageHeight)
//                . '<h4>' . $pastry->getPrice() . '</h4>'
//                . '</tr>';
//        }
//        $elem .= '</tbody></table>';
//        return $elem;
//    }

    public function randomPastry (): Pastry { return $this->list[array_rand($this->list)]; }
}