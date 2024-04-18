<?php

namespace app\pages;

use app\interfaces\Renderable;
use app\models\concretes\InventoryItem;
use app\models\concretes\Review;
use app\models\concretes\User;
use app\pages\Page;
use Exception;

class ProductPage extends Page {

    public const LOW_STOCK_AMOUNT = 15;
    private InventoryItem $product;

    /**
     * @param InventoryItem $product
     */
    public function __construct (InventoryItem $product) {
        parent::__construct($product->getPastry()->__toString()) ;
        $this->product = $product;
    }

    public function addToCartForm (): string {
        return '<div class="form">'
            . '<form name="addItemToCartForm" id="addItemToCartForm" method="post" action="processAddToCartForm.php">'
                . '<fieldset>'
                    . '<legend>Add to Your Cart</legend>'
                    . '<div class="formElement"><p>' . InventoryItem::quantitySelector() . '</p></div>'
                    . '<p><input type="submit" name="addToCart" id="addToCart" value="Add to Cart"></p>'
                . '</fieldset>'
            . '</form>'
        . '</div>';
    }

    public function oneClickBuyForm (User $user=null): string {
        return '<div class="popUp">'
            . '<form class="popUp" id="oneClickBuyForm" name="oneClickBuyForm" method="post" action="processOneClickBuyForm.php">'
                . '<fieldset>'
                . '<legend>Buy with One Click</legend>'
                    . '<div class="formElement"><p>' . $user->getCreditCards()->selector() . '</p></div>'
                    . '<div class="formElement"><p>' . $user->getShippingAddresses()->selector() . '</p></div>'
                    . '<div class="formElement"><p>' . InventoryItem::quantitySelector() . '</p></div>'
                    . '<input type="submit" id="oneClickBuyButton" value="Buy with One-Click">'
                    . '</div>'
                . '</fieldset>'
            . '</form>'
        . '</div>';
    }

    public function reviewForm (): string {
        return '<div class="form">'
            . '<form id="ratingForm" name="ratingForm" method="post" action="processReviewForm.php">'
            . '<fieldset>'
            . '<legend>Write a Review></legend>'
            . '<div class="formElement"><p>' . Review::ratingSelector() . '</p></div>'
            . '<div class="formElement">'
                . '<p>'
                    . '<label for="reviewTitle">Title</label>'
                    . '<input type="text" id="reviewTitle" name="reviewTitle" size="50" required>'
                    . '</p>'
                .  '</div>'
            . '<div class="formElement">'
                . '<p>'
                    . '<label for="comment">Comment</label><br>'
                    . '<textarea id="comment" name="comment" cols="100">...</textarea>'
                    . '</p>'
                . '</div>'
            . '<input type="submit" id="submitRating" name="submitRating" value="Add Your Rating">'
            . '</fieldset>'
            . '</form>'
        . '</div>';
    }

    /**
     * @throws Exception
     */
    public function body (): string {
        $message = '';
        if ($this->product->getQuantity() <= ProductPage::LOW_STOCK_AMOUNT) {
            $message = 'Only ' . $this->product->getQuantity() . ' is left in stock. Order now.';
        }
        $elem = '<body><h1>' . $this->product->getPastry()->getName()
            . ' ' . number_format($this->product->getPastry()->getPrice(), 2) . '</h1>'
            . '<div class="message" hidden><h3 class="message" hidden>' . $this->getStatusMessage() . '</h3></div>'
            . '<div class="dashboard">'
                . '<div class="dashboardItem">' . $this->product->toTable() . '</div>'
                . '<div class="dashboardItem"><emph><p>Average Rating ' . 10 . ' Stars!!</p></emph></div>'
                . '<div class="dashboardItem"><p>' . $message . '</p>'
                    . '<p>' . self::addToCartForm() . '</p>' //<p>' . self::oneClickBuyForm() . '</p>'
                . '</div>'
                . '<div class="dashboardItem"><p>' . self::reviewForm() . '</p></div>'
            . '</div>';
        $reviews = $this->product->getPastry()->getReviews();
        if (!is_null($reviews) && count($reviews->getItems()) > 0) {
            $elem .= '<div><h2>Reviews</h2>' . $reviews->toTable() . '</div>';
        }
        return $elem . '</body>';
    }

    /**
     * @throws Exception
     */
    public function getPage (User $user=null): string {
        return Generate::htmlHead($this->getTitle())
            . Generate::header()
            . Generate::navbar()
            . $this->body($user)
            . Generate::footer();
     }
}