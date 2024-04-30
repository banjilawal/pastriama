<?php

namespace app\elements;

use app\interfaces\Dashboard;
use app\interfaces\Render;
use app\models\catalogs\ReviewsCatalog;
use app\models\concretes\InventoryItem;
use app\models\concretes\NewReview;
use app\models\concretes\User;
use app\models\collections\Reviews;
use app\elements\PageElement;
use app\utils\AssemblePage;
use Exception;

class ProductPageElement extends PageElement implements Render, Dashboard {

    public const LOW_STOCK_AMOUNT = 15;
    private InventoryItem $product;

//    private string $bodyHeading;
    private string $dashboardHeading;
    private string $mainSectionHeading;

    /**
     * @param InventoryItem $product
     */
    public function __construct (InventoryItem $product) {
        parent::__construct($product->getPastry()->__toString());
        $this->product = $product;
        $this->reviews = new Reviews();
//        $this->bodyHeading = '';
//        $this->mainSectionHeading = '';
        $this->dashboardHeading = '';
    }

    public function getDashboardHeading (): string {
        return $this->dashboardHeading;
    }

    public function setDashboardHeading (string $dashboardHeading): void {
        $this->dashboardHeading = $dashboardHeading;
    }

    /**
     * @throws Exception
     */
    public function getReviews (): ?Reviews {
        $catalog = ReviewsCatalog::getInstance();
        echo $catalog->getReviews();
        return $catalog->getReviews();

//        return $reviews->filterByPastry($this->product->getPastry());
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

    public function addOneClickBuyForm (): string { return ''; }

//    public function oneClickBuyForm (User $user): string {
//        return '<div class="popUp">'
//            . '<form class="popUp" id="oneClickBuyForm" name="oneClickBuyForm" method="post" action="processOneClickBuyForm.php">'
//                . '<fieldset>'
//                . '<legend>Buy with One Click</legend>'
//                    . '<div class="formElement"><p>' . $user->getCreditCards()->selector() . '</p></div>'
//                    . '<div class="formElement"><p>' . $user->getShippingAddresses()->selector() . '</p></div>'
//                    . '<div class="formElement"><p>' . InvoiceItem::quantitySelector() . '</p></div>'
//                    . '<input type="submit" id="oneClickBuyButton" value="Buy with One-Click">'
//                    . '</div>'
//                . '</fieldset>'
//            . '</form>'
//        . '</div>';
//    }

    public function addReviewForm (): string {
        return '<div class="form">'
            . '<form id="ratingForm" name="ratingForm" method="post" action="processReviewForm.php">'
            . '<fieldset>'
            . '<legend>Write a Review</legend>'
            . '<div class="formElement"><p>' . NewReview::ratingSelector() . '</p></div>'
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
    public function dashboard (): string {
//        $message = '';
//        if ($this->product->getQuantity() <= ProductPage::LOW_STOCK_AMOUNT) {
//            $message = 'Only ' . $this->product->getQuantity() . ' is left in stock. Order now.';
//        }
        return
            '<div class="dashboard">'
            . $this->encapsulate('div', $this->dashboardHeading, 'dashboardHeading')
            . $this->encapsulate('div', $this->product->toTable(), 'dashboardItem')
            . $this->encapsulate('div', '<h3>Average Rating: 10</h3>', 'dashboardItem')
            . $this->encapsulate('div', $this->addToCartForm(), 'dashboardItem')
            . $this->encapsulate('div', $this->addOneClickBuyForm(), 'dashboardItem')
            . $this->encapsulate('div', $this->reviewsSection(), 'dashboardItem')
            . '</div>';
    }

    /**
     * @throws Exception
     */
    public function reviewsSection (): string {
        return '<div class="recordsContainer">'
            . $this->encapsulate('div', $this->addReviewForm(), 'recordWriter')
            . $this->encapsulate('div', $this->getReviews()->toTable(), 'recordsReader')
            . '</div>';
    }


    /**
     * @throws Exception
     */
    public function mainSection (): string {
       return '<main>'
               . '<h2>' . $this->getMainSectionHeading() . '</h2>'
               . $this->dashboard()
           . '</main>';
//        $message = '';
//        if ($this->product->getQuantity() <= ProductPage::LOW_STOCK_AMOUNT) {
//            $message = 'Only ' . $this->product->getQuantity() . ' is left in stock. Order now.';
//        }
//        $elem = '<main>'
//            . '<h1>' . $this->mainSectionHeading . '</h1>'
//            //$this->product->getPastry()->getName(). ' ' . number_format($this->product->getPastry()->getPrice(), 2) . '</h1>'
//            . '<p><emp>' . $this->product . ' image_path:' . $this->product->getPastry()->getImageName() . '</emp></p>'
//            . '<div class="message" hidden><h3 class="message" hidden>' . $this->getStatusMessage() . '</h3></div>'
//            . '<div class="dashboard">'
//            . '<div class="dashboardItem">' . $this->product->toTable() . '</div>'
//            . '<div class="dashboardItem"><emph><p>Average Rating ' . 10 . ' Stars!!</p></emph></div>'
//            . '<div class="dashboardItem"><p>' . $message . '</p>'
//            . '<p>' . self::addToCartForm() . '</p>' //<p>' . self::oneClickBuyForm() . '</p>'
//            . '</div>'
//            . '<div class="dashboardItem"><p>' . self::reviewForm() . '</p></div>'
//            . '</div>';
////        $reviews = $this->product->getPastry()->getReviews();
////        if (!is_null($reviews) && count($reviews->getItems()) > 0) {
////            $elem .= '<div><h2>Reviews</h2>' . $reviews->toTable() . '</div>';
////        }
//        return $elem
//        . '</main>';
    }


    /**
     * @throws Exception
     */
    public function body (): string {
        return '';
//        return '<body>'
//                . '<h1>' . $this->getBodyHeading() . '</h1>'
//                . $this->mainSection()
//            . '</body>';
    }

    public function page (): string {
        return AssemblePage::assemble($this);
    }

//    /**
//     * @throws Exception
//     */
//    public function page (): string {
//        return Generate::htmlHead($this->getTitle())
//            . Generate::header()
//            . Generate::navbar()
//            . $this->getBody()
//            . Generate::footer();
//     }
}