<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\StoreItem;
use DateTime;

class Wish extends Entity {
    private int $id;
    private Pastry $pastry;
    private DateTime $creationTime;

    public function __construct(int $id, Pastry $pastry, DateTime $creationTime) {
        parent::__construct($id);
        $this->pastry = $pastry;
        $this->creationTime = $creationTime;
    }

    public function getPastry (): Pastry {
        return $this->pastry;
    }

    public function getCreationTime (): DateTime {
        return $this->creationTime;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Wish) {
            return parent::equals($object)
                && $this->id === $object->getId()
                && $this->pastry->equals($object->getPastry())
                && $this->creationTime === $object->getCreationTime();
        }
        return false;
    }

    public function __toString (): string {
        return 'id:' . $this->getId()
            . ' ' . $this->pastry->getName()
            . ' price:' . number_format($this->pastry->getPrice())
            . ' created at:' . $this->creationTime->format(DATE_TIME_FORMAT);
    }

    public function toRow (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        $elem = '<tr id="wishRow"' . $this->getId() . ' onclick="rowClickHandler(' . $this->getId() . ')">'
            . '<td>' . $this->creationTime->format(DATE_TIME_FORMAT) . '</td>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->pastry->getImgTag($imageWidth, $imageHeight) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>';
        $elem .= '</tr>';
        return $elem;
    }

    public function tableHeader (): string {
        return '<table id="wishTable_"'. $this->pastry->getId() . '>'
            . '<thead>'
            . '<tr>'
            . '<th>Date Added</th>'
            . '<th>Id</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr></thead>';
    }

    public function toTable (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
    ): string {
        return $this->tableHeader() . $this->toRow($imageWidth, $imageHeight) . '</tbody></table>';
    }
//        return '<table id="wishTable_"'. $this->product->getId() . '>'
//            . '<thead>'
//            . '<tr>'
//            . '<th>Date Added</th>'
//            . '<th>Picture</th>'
//            . '<th>Name</th>'
//            . '<th>Description</th>'
//            . '<th>Price</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>' . $this->toRow()
//            . '<tr>'
//            . '<td>' . $this->creationTime->format('Y-m-d H:i:s') . '</td>'
//            . '<td>' . $this->product->getPastry()->getName() . '</td>'
//            . '<td>' . $this->product->getPastry()->getImgTag($imageWidth, $imageHeight) . '</td>'
//            . '<td>' . $this->product->getPastry()->getDescription() . '</td>'
//            . '<td>' . $this->product->getPastry()->getPrice() . '</td>'
//            . '</tr>'
//            . '</tbody>'
//            . '</table>';
//    }
//
//
//    private function tableRows (int $imageWidth, int $imageHeight): string {
//        return '<tr>'
//        . '<td>' . $this->creationTime->format('Y-m-d H:i:s') . '</td>'
//        . '<td>' . $this->product->getPastry()->getName() . '</td>'
//        . '<td>' . $this->product->getPastry()->getImgTag($imageWidth, $imageHeight) . '</td>'
//        . '<td>' . $this->product->getPastry()->getDescription() . '</td>'
//        . '<td>' . $this->product->getPastry()->getPrice() . '</td>'
//        . '</tr>';
//    }
}