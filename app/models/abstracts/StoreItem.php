<?php declare(strict_types=1);

namespace app\models\abstracts;


abstract class StoreItem extends NamedEntity {
    const DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH = 90;
    const DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT = 100;
    const DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH = 180;
    const DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT = 160;

    private string $description;
    private string $imageName;
    private float $price;

    /**
     * @param string $description
     * @param string $imageName
     * @param float $price
     */
    public function __construct(
        int $id,
        string $name,
        string $description,
        string $imageName,
        float $price
    ) {
        parent::__construct ($id, $name);
        $this->description = $description;
        $this->imageName = $imageName;
        $this->price = $price;
    }

    public function getDescription (): string {
        return $this->description;
    }

    public function getImageName (): string {
        return $this->imageName;
    }

    public function getPrice (): float {
        return $this->price;
    }

    public function setDescription (string $description): void {
        $this->description = $description;
    }

    public function setImageName (string $imageName): void {
        $this->imageName = $imageName;
    }

    public function setPrice (float $price): void {
        $this->price = $price;
    }

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof StoreItem) {
            return parent::equals($object)
                && $this->price === $object->getPrice()
                && $this->imageName === $object->getImageName()
                && $this->description === $object->getDescription();
        }
        return false;
    }

    public function __toString (): string {
        return parent::__toString()
            . ' image_path:' . $this->imageName
            . ' description:' . $this->description
            . ' price:' . number_format($this->price, 2);
    }


    public function getImgTag (
        int $width=self::DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
        int $height=self::DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
        ): string {
        return '<img src="' . $this->imageName
            . '" width="' . $width
            . '" height="' . $height
            . '">';
    }

    public function toRow (
        int $imageWidth=self::DEFAULT_STORE_ITEM_ROW_IMAGE_WIDTH,
        int $imageHeight=self::DEFAULT_STORE_ITEM_ROW_IMAGE_HEIGHT
    ): string {
        return '<tr class="store-item-row" id="store-item-id-"' . $this->getId() . ' onclick="rowClickHandler($row)">'
            . '<td id="id-cell" hidden>' . $this->getId() . '</td>'
            . '<td>' . $this->getImgTag($imageWidth, $imageHeight) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->getName() . '</td>'
            . '<td>' . $this->description . '</td>'
            . '<td>' . number_format($this->price, 2) . '</td>'
            . '</tr>';
    }

    public function toTable (
        int $imageWidth=self::DEFAULT_STORE_ITEM_TABLE_IMAGE_WIDTH,
        int $imageHeight=self::DEFAULT_STORE_ITEM_TABLE_IMAGE_HEIGHT
    ): string {
        return '<table class="item-table">'
            . '<thead>'
            . '<tr>'
            . '<th>StoreItem Image</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->getImgTag($imageWidth, $imageHeight) . '</td>'
            . '<td>' . $this->getName() . '</td>'
            . '<td>' . $this->description . '</td>'
            . '<td>' . number_format($this->price, 2) . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>'
            . '<br>product id:' . $this->getId();
    }
}