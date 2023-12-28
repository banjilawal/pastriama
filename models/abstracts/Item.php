<?php
namespace model\abstracts;

use Exception;


abstract class Item extends NamedEntity {

    private string $description;
    private string $imageName;
    private float $price;

    
    
    /**
     * @param int $id
     * @param string $name
     * @param float $price
     * @param string $imageName
     * @param string $description
     * @throws Exception
     */
    public function __construct (
        int $id,
        string $name,
        string $description,
        string $imageName,
        float $price
    ) {
        parent::__construct($id, $name);
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
    
    /**
     * @throws Exception
     */
    public function setDescription (string $description): void {
        if (!empty($description)) {
            throw new Exception('Attempting to set the description to an empty string ');
        }
        $this->description = $description;
    }
    
    /**
     * @throws Exception
     */
    public function setImageName (string $imageName): void {
        if (!empty($imageName)) {
            throw new Exception('Attempting to set the image name to an empty string ');
        }
        $this->imageName = $imageName;
    }
    
    
    /**
     * @throws Exception
     */
    public function setPrice (float $price): void {
        if ($price < LOWEST_PRICE || $price > HIGHEST_PRICE) {
            throw new Exception($price . ' is outside the acceptable retail price range');
        }
        $this->price = $price;
    }
 
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Item) {
            return parent::equals($object)
                && $this->price === $object->getPrice()
                && $this->imageName === $object->getImageName()
                && $this->description === $object->getDescription();
        }
        return false;
    }
    

    public function __toString(): string {
        return parent::__toString()
            . ' image_path:' . $this->imageName
            . ' description:' . $this->description
            . ' price:' . $this->price;
    }
    

    public function loadImage (int $width, int $height): string {
        return '<img src="' . $this->imageName
            . '" width="' . $width
            . '" height="' . $height
            . '">';
    }
    

    public function toRow (): string {
        return '<tr id="' . $this->getId() . '" name="' . $this->getId() . '" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->getId() . '</td>'
            . '<td>' . $this->loadImage(90, 100) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->getName() . '</td>'
            . '<td>' . $this->description . '</td>'
            . '<td>' . $this->price . '</td>'
            . '</tr>';
    }


    public function toTable (): string {
        return '<table class="item-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->loadImage(300, 400) . '</td>'
            . '<td>' . $this->getName() . '</td>'
            . '<td>' . $this->description . '</td>'
            . '<td>' . $this->price . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>'
            . '<br>product id:' . $this->getId();
    }
} // end class Item