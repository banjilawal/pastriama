<?php

namespace app\elements\user;

use app\models\concretes\Wish;
use app\models\collections\Wishlist;
use app\elements\PageElement;

class WishlistPageElement extends PageElement {

    private Wishlist $wishList;

    /**
     * @param Wishlist $wishList
     */
    public function __construct (Wishlist $wishList, string $title) {
        parent::__construct($title);
        $this->wishList = $wishList;
    }

    public function addWishForm (): string {
    }

    public function removeWishForm (): string {

    }


    public function body (): string {
        // TODO: Implement body() method.
    }

    public function page (): string {
        // TODO: Implement getPage() method.
    }
}