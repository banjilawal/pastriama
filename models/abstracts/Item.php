<?php
namespace model\abstract;

use model\abstract\NamedEntity;

abstract class Item extends NamedEntity {
    private float $price;
    private string $image_name;
    private string $description;

    /**
     * @param float $price
     * @param string $image_name
     * @param string $description
     */
    public function __construct (
        int $id,
        string $name,
        float $price,
        string $image_name,
        string $description
    ) {
        parent::__construct($id, $name);
        $this->price = $price;
        $this->image_name = $image_name;
        $this->description = $description;
    }

    public function get_price (): float { return $this->price; }
    public function get_image_name (): string { return $this->image_name; }
    public function get_description (): string { return $this->description; }

    public function set_price (float $price): void {
        if ($price < LOWEST_PRICE || $price > HIGHEST_PRICE) {
            throw new Exception($price . ' is outside the acceptable retail price range');
        }
        $this->price = $price;
    } // close set_price


    public function set_image_name (string $image_name): void {
        if (!empty($this->image_name)) {
            throw new Exception('The image path has already been set to ' . $this->image_name);
        }
        $this->image_name = $image_name;
    } // close set_image_path


    public function set_description (string $description): void {
        $this->description = $description;
    } // close description
    
    
    public function equals ($object): boolean {
        if ($object instanceof Item) {
            return parent::equals($object)
                && $this->price === $object->get_price()
                && $this->image_name === $object->get_image_name()
                && $this->get_description() === $object->description;
        }
        return false;
    }

    public function __toString(): string {
        return parent::__toString()
            . ' price:' . $this->price
            . ' image_path:' . $this->image_name
            . ' description:' . $this->description;
    }

    public function load_image (int $width, int $height): string {
        return '<img src="' . $this->image_name
            . '" width="' . $width
            . '" height="' . $height
            . '">';
    } // close load_image

    public function to_row (): string {
        return '<tr id="' . $this->get_id() . '" name="' . $this->get_id() . '" onclick="send_protein_bar(this)">'
            . '<td hidden>' . $this->get_id() . '</td>'
            . '<td>' . $this->load_image(90, 100) . '</td>' #<img src="' . $this->imagePath . '" width="90" height="100"></td>'
            . '<td>' . $this->get_name() . '</td>'
            . '<td>' . $this->description . '</td>'
            . '<td>' . $this->grams . '</td>'
            . '<td>' . $this->price . '</td>'
            . '</tr>';
    } // close to_row

    public function to_table (): string {
        $elem = '<table class=>'
            . '<thead>'
            . '<tr>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Grams</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->load_image(300, 400) . '</td>'
            . '<td>' . $this->get_name() . '</td>'
            . '<td>' . $this->description . '</td>'
            . '<td>' . $this->price . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>'
            . '<br>product id:' . $this->get_id();
        return $elem;
    } //close to_table
} // end class Item