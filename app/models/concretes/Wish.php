<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\StoreItem;
use DateTime;

class Wish extends Entity {
    private Pastry $pastry;
    private DateTime $submissionTime;

    public function __construct(Pastry $pastry) {
        parent::__construct($pastry->getId());
        $this->pastry = $pastry;
        $this->submissionTime = DateTime::createFromFormat('U', time());
    }

    public function getPastry (): Pastry {
        return $this->pastry;
    }

    public function getSubmissionTime (): DateTime {
        return $this->submissionTime;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Wish)
            return  parent::equals($object)
                && $this->pastry->equals($object->getPastry())
                && $this->submissionTime === $object->getSubmissionTime();
        return false;
    }

    public function __toString (): string {
        return parent::__toString()
            . ' ' . $this->pastry
            . ' added on:' . $this->submissionTime->format('Y-m-d H:i:s');
    }

    public function toRow (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        return '<tr id="wishRow">'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getImgTag($imageWidth, $imageHeight) . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '</tr>';
    }

    public function toTable (
        int $imageWidth=StoreItem::DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
        int $imageHeight=StoreItem::DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
    ): string {
        return '<table id="wishTable">'
            . '<thead>'
            . '<tr>'
            . '<th>Date Added</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->submissionTime->format('Y-m-d H:i:s') . '</td>'
            . '<td>' . $this->pastry->getImgTag($imageWidth, $imageHeight) . '</td>'
            . '<td>' . $this->pastry->getName() . '</td>'
            . '<td>' . $this->pastry->getDescription() . '</td>'
            . '<td>' . $this->pastry->getPrice() . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';
    }
}