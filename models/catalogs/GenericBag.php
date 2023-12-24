<?php
namespace models\containers;

use model\abstract\AnonymousEntity;

class GenericBag extends AnonymousEntity {
    private $item;
    
    /**
     * Constructor to initialize the generic container with an item.
     *
     * @param T $item
     */
    public function __construct( $item) {
        $this->item = $item;
    }
    
    /**
     * Get the stored item.
     *
     * @return T
     */
    public function get_item () {
        return $this->item;
    }
    
    /**
     * Set a new item.
     *
     * @param T $item
     */
    public function set_item ($item) {
        $this->item = $item;
    }
} // end class GenericBag