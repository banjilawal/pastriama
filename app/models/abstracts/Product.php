<?php declare(strict_types=1);

namespace app\models\abstracts;

define ('DEFAULT_ROW_IMAGE_WIDTH', 90);
define ('DEFAULT_ROW_IMAGE_HEIGHT', 100);
define ('DEFAULT_TABLE_IMAGE_WIDTH', 180);
define ('DEFAULT_TABLE_IMAGE_HEIGHT', 160);
define ('DEFAULT_DASHBOARD_IMAGE_WIDTH', 180);
define ('DEFAULT_DASHBOARD_IMAGE_HEIGHT', 160);

use app\models\catalogs\ReviewsCatalog;
use app\models\collections\Reviews;
use Exception;

abstract class Product extends NamedEntity {

    private string $description;
    private string $imageName;
    private float $price;

    /**
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $imageName
     * @param float $price
     * @throws Exception
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


    /**
     * @throws Exception
     */

    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Product) {
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
        int $width=DEFAULT_TABLE_IMAGE_WIDTH,
        int $height=DEFAULT_TABLE_IMAGE_HEIGHT
        ): string {
        return '<img src="' . $this->imageName
            . '" width="' . $width
            . '" height="' . $height
            . '">';
    }
}