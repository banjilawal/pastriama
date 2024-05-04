<?php declare(strict_types=1);

namespace app\templates;

define ('USER_ORDERS_PAGE', 'userOrders.php');
define ('USER_WISHES_PAGE', 'userWishes.php');
define ('USER_ADDRESSES_PAGE', 'userAddresses.php');
define ('USER_CREDIT_CARDS_PAGE', 'userAddresses.php');
define ('ACCOUNT_SECURITY_PAGE', 'accountSecurity.php');

use app\enums\ListTag;
use app\enums\StylingClass;
use app\models\abstracts\Product;
use app\models\collections\Reviews;
use app\models\concretes\CreditCard;
use app\models\concretes\InventoryItem;
use app\models\concretes\Order;
use app\models\concretes\User;
use app\models\concretes\Pastry;
use app\models\concretes\review;
use app\models\concretes\User;
use app\models\concretes\Wish;
use app\utils\Convert;
use app\utils\Create;

class Dashboard {

    public static function user (User $user): string {
        $elem = '<ul ' . StylingClass::DASHBOARD_LIST->value . '>'
            . Create::addListItem(
                Create::addLink('shoppingCartPage.php', 'Your Shopping Cart', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Create::addListItem(
                Create::addLink(USER_ADDRESSES_PAGE, 'Manage Your Addresses', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Create::addListItem(
                Create::addLink('creditCardPage.php', 'Your Credit Cards', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Create::addListItem(
                Create::addLink(ACCOUNT_SECURITY_PAGE, 'Your Email, Password and verification phone', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Create::addListItem(
                Create::addLink(USER_WISHES_PAGE, 'Your Wishlist', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . '</ul>';
        return Create::dashboard('Your Dashboard ' . $user->getFirstname(), $elem);
    }

    public static function pastry (Pastry $pastry): string {
        $elem = Create::dashboardMember($pastry->getImgTag()) . Create::dashboardMember($pastry->getDescription())
            . Create::dashboardSection(
                (number_format($pastry->getPrice(), 2)),
                Create::dashboardMember(Create::addList(ListTag::UNORDERED, [HTMLForm::addToCartForm()])), 2)
            . Create::dashboardMember('Average rating out of total ratings')
            . Create::dashboardSection('Would You Like to Add a Review?', HTMLForm::reviewForm(), 2);
        return Create::dashboard($pastry->getName(), $elem);
    }

    /**
     * @throws \Exception
     */
    public static function product (Product $product, Reviews $reviews): string {
//        $reviews = $product->getReviews();
        $elem = Create::dashboardMember($product->getImgTag()) . Create::dashboardMember($product->getDescription())
            . Create::dashboardSection(
                (number_format($product->getPrice(), 2)),
                Create::dashboardMember(Create::addList(ListTag::UNORDERED, [HTMLForm::addToCartForm()])), 2)
            . Create::dashboardMember('Average rating:' . $reviews->getAverageRating() . ' out of ' . count($reviews->getList()))
            . Create::dashboardSection('Would You Like to Add a Review?', HTMLForm::reviewForm(), 5)
            . Create::dashboardSection('Product Reviews', HTMLList::reviews($reviews));
        return Create::dashboard($product->getName(), $elem);
    }

    public static function review (review $review): string {
        $h2 = Convert::ratingToStars($review->getRating())->name . ' Dashboard.php' . $review->getTitle();
        $h3 = 'Reviewed on ' . $review->getTimestamp()->format(DATE_FORMAT);
        $reviewSection = Create::dashboardSection($h3, Create::dashboardMember($review->getComment()), 6);
        $productSection = Create::dashboardSection(
            'Product Details',
            $review->getProduct()->getImageName() . ' Dashboard.php' . $review->getProduct()->getName(), 6);
        return Create::dashboard('Customer Review', $reviewSection . $productSection);
    }

    public static function orderItem (Order $order): string {
        return '';
    }

    public static function wish (Wish $wish): string {
        return '';
    }

    public static function creditCard (CreditCard $card): string {
        return '';
    }

    public static function order (Order $order): string {
        return '';
    }

    private function orderItemDashboardHeading (InventoryItem $product): string {
        return '<div class="'. StylingClass::CONTAINER->value . '">'
            . '<table>'
            . '<thead>'
            . '<tr>'
            . '<th>Order Placed</th>'
            . '<th>Total</th>'
            . '<th>Ship To</th>'
            . '<th>Order #' . $this->getId() . '</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' .  $this->submissionTime->format(DATE_FORMAT) . '</td>'
            . '<td>' . number_format($product->getCost(), 2) . '</td>'
            . '<td>' . $this->shipToAddress . '</td>'
            . '<td><a href="orderPage.php">View order details</a></td>'
            . '</tr>'
            . '</tbody>'
            . '</table></div>';
    }

    private function orderItemDashboard (InventoryItem $product): string {
        return self::orderItemDashboardHeading($product)
            . '<div class"' . StylingClass::ORDER_ITEM_DASHBOARD->value . '">'
            . '<a href="productPage.php">' . $product->getPastry()->getName() . '</a>'
            . '<div class="' .  StylingClass::CONTAINER->value . '">'
            . '<ul class="' . StylingClass::INTERACTIVE_LIST->value .  '">'
            . '<li><a href="returnPage.php" class="'. StylingClass::BEVELED_LINK->value. '">Return Product</a></li>'
            . '</ul>'
            .  '</div>'
            . '</div>';
    }

//    public static function product (InvoiceItem $product): string {
//        return $product->toTable();
//    }

//    public const TAG = '<div class="' . StylingClass::INTERACTIVE_LIST->value . '">';
//    public const CONTROL_TAG = ''
//    public static function user (User $user): string  {
//        $unorderedList = '<div class="' . StylingClass::DASHBOARD_MEMBER->value . '">'
//           . '$tag .  '<a href="orders.ph">Your Orders and Returns</a></div>';
//        $dashboard = '<div class="' . StylingClass::DASHBOARD_CONTAINER->value . '">';
//
//
//        return $dashboard . $unorderedList . '</div></div';
//    }

}