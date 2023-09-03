<?php
    Namespace Shop\Model;

    require_once('../bootstrap.php');

    interface Itemable {

        public function get_id ();
        public function get_name ();
        public function get_price ();
        public function get_image_path ();
        public function get_description ();
        public function load_image (int $width, int $height);

        public function id (String $id);
        public function name (String $name);
        public function price (float $price);
        public function imagePath (String $path);
        public function description (String $description);

    } // end class OrderItem
?>