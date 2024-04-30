<?php declare(strict_types=1);

namespace app\models\concretes;


use app\models\collections\InvoiceItems;
use app\models\collections\Addresses;
use app\models\catalogs\ReviewsCatalog;
use app\models\abstracts\Person;

use app\models\collections\CreditCards;
use app\models\collections\Orders;
use App\models\collections\Reviews;
use app\models\catalogs\OrdersCatalog;
use app\models\collections\Wishlist;
use DateTime;
use Exception;

class User extends Person {

    private Wishlist $wishList;
    private InvoiceItems $shoppingCart;
    private CreditCards $creditCards;
    private Addresses $shippingAddresses;

    /**
     * @throws Exception
     */
    public function __construct (
        int           $id,
        string        $firstname,
        string        $lastname,
        DateTime      $birthdate,
        Phone         $phone,
        EmailAddress  $emailAddress,
        string        $password,
        PostalAddress $billingAddress,
        CreditCard    $creditCard
    ) {
        parent::__construct(
            $id,
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $emailAddress,
            $password,
            $billingAddress
        );
        $this->shippingAddresses = new Addresses();
        $this->creditCards = new CreditCards();
        $this->shoppingCart = new InvoiceItems();
        $this->wishList = new Wishlist();

//        $this->shippingAddresses->setPrimaryShippingAddress($billingAddress);
        $this->creditCards->addCard($creditCard);
    }

    public function getBillingAddress (): PostalAddress {
        return $this->getPostalAddress();
    }

    public function getShippingAddresses (): Addresses {
        return $this->shippingAddresses;
    }

    public function getCreditCards (): CreditCards {
        return $this->creditCards;
    }

    public function getShoppingCart (): InvoiceItems {
        return $this->shoppingCart;
    }

    public function getWishList(): Wishlist {
        return $this->wishList;
    }

//    public function displayShoppingCart (): string {
//        $elem = '<div class="shoppingCart"><ul class="shoppingCart">';
//        foreach ($this->shoppingCart as $id => $item) {
//            $checkboxId = 'saveProduct_' . $id;
//            $radioButtonId = 'deleteProduct_' .$id;
//            $elem .= '<li class="shoppingCartItem">'
//                . '<label for ' . $checkboxId . '>Save for later</label>'
//                . '<input type="checkbox" id="' . $checkboxId . '" name="save" value="' . $id .'">'
//                . '&nbsp;' .$item->toTable() . '&nbsp;'
//                . '<label for ' . $radioButtonId . '>Remove from your shopping cart</label>'
//                . '<input type="radio" id="' .$radioButtonId . '" name="delete" value="'.  $id . '">';
//        }
//        return $elem . '</ul></div>';
//    }

//    /**
//     * @throws Exception
//     */
//    public function getOrders (Orders $source): Orders { //DateTime $startDate, DateTime $endDate): Orders {
//        return $source->filterByUser($this);
//    }
//
//    /**
//     * @throws Exception
//     */
//    public function getReviews (Reviews $source): Reviews { //DateTime $startDate, DateTime $endDate): ReviewList {
//        return $source->filterByUser($this); //userSearch($this, $startDate, $endDate);
//    }

    public function equals ($object): bool {
        if ($object instanceof User) return parent::equals($object);
        return false;
    }
}