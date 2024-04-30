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
use app\models\concretes\CreditCard;
use app\models\concretes\InventoryItem;
use app\models\concretes\NewOrder;
use app\models\concretes\Pastry;
use app\models\concretes\NewReview;
use app\models\concretes\User;
use app\models\concretes\Wish;
use app\utils\Convert;
use app\utils\Util;

class Dashboard {

    public static function user (User $user): string {
        $elem = '<ul ' . StylingClass::DASHBOARD_LIST->value . '>'
            . Util::addListItem(
                util::addLink(USER_ORDERS_PAGE, 'Your Orders', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Util::addListItem(
                util::addLink(USER_ADDRESSES_PAGE, 'Manage Your Addresses', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Util::addListItem(
                util::addLink(USER_CREDIT_CARDS_PAGE, 'Your Credit Cards', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Util::addListItem(
                util::addLink(ACCOUNT_SECURITY_PAGE, 'Your Email, Password and verification phone', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . Util::addListItem(
                util::addLink(USER_WISHES_PAGE, 'Your Wishlist', StylingClass::BEVELED_LINK),
                StylingClass::DASHBOARD_MEMBER
            )
            . '</ul>';
        return Util::dashboard('Your Dashboard ' . $user->getFirstname(), $elem);
    }

    public static function pastry (Pastry $pastry): string {
        $elem = Util::dashboardMember($pastry->getImgTag()) . Util::dashboardMember($pastry->getDescription())
            . Util::dashboardSection(
                (number_format($pastry->getPrice(), 2)),
                Util::dashboardMember(Util::addList(ListTag::UNORDERED, [HTMLForm::addToCartForm()])), 2)
            . Util::dashboardMember('Average rating out of total ratings')
            . Util::dashboardSection('Would You Like to Add a Review?', HTMLForm::reviewForm(), 2);
        return Util::dashboard($pastry->getName(), $elem);
    }

    /**
     * @throws \Exception
     */
    public static function product (Product $product): string {
//        $reviews = $product->getReviews();
        $elem = Util::dashboardMember($product->getImgTag()) . Util::dashboardMember($product->getDescription())
            . Util::dashboardSection(
                (number_format($product->getPrice(), 2)),
                Util::dashboardMember(Util::addList(ListTag::UNORDERED, [HTMLForm::addToCartForm()])), 2);
//            . Util::dashboardMember('Average rating:' . $reviews->getAverageRating() . ' out of ' . count($reviews->getList()))
//            . Util::dashboardSection('Would You Like to Add a Review?', HTMLForm::reviewForm(), 2);
//            . Util::dashboardSection('Product Reviews', HTMLList::reviews($reviews));
        return Util::dashboard($product->getName(), $elem);
    }

    public static function review (NewReview $review): string {
        $h2 = Convert::ratingToStars($review->getRating())->name . ' Dashboard.php' . $review->getTitle();
        $h3 = 'Reviewed on ' . $review->getSubmissionTime()->format(DATE_FORMAT);
        $reviewSection = Util::dashboardSection($h2, Util::dashboardSection($h3, $review->getComment(), 3), 2);
        $productSection = Util::dashboardSection(
            'InvoiceItem Details',
            $review->getProduct()->getImageName() . ' Dashboard.php' . $review->getProduct()->getName(), 2);
        return Util::dashboard('Customer Review', $reviewSection . $productSection);
    }

    public static function orderItem (NewOrder $order): string {
        return '';
    }

    public static function wish (Wish $wish): string {
        return '';
    }

    public static function creditCard (CreditCard $card): string {
        return '';
    }

    public static function order (NewOrder $order): string {
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