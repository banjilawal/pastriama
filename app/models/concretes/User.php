<?php declare(strict_types=1);

namespace app\models\concretes;


use app\models\lists\Products;
use app\models\lists\PostalAddressList;
use app\models\singletons\ReviewsCatalog;
use app\models\abstracts\Person;

use app\models\lists\CreditCards;
use app\models\lists\Orders;
use App\models\lists\Reviews;
use app\models\singletons\OrdersCatalog;
use app\models\lists\Wishlist;
use DateTime;
use Exception;

class User extends Person {

    private Wishlist $wishList;
    private Products $shoppingCart;
    private CreditCards $creditCards;
    private PostalAddressList $shippingAddresses;

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
        $this->shippingAddresses = new PostalAddressList();
        $this->creditCards = new CreditCards();
        $this->shoppingCart = new Products();
        $this->wishList = new Wishlist();

//        $this->shippingAddresses->setPrimaryShippingAddress($billingAddress);
        $this->creditCards->addCard($creditCard);
    }

    public function getBillingAddress (): PostalAddress {
        return $this->getPostalAddress();
    }

    public function getShippingAddresses (): PostalAddressList {
        return $this->shippingAddresses;
    }

    public function getCreditCards (): CreditCards {
        return $this->creditCards;
    }

    public function getShoppingCart (): Products {
        return $this->shoppingCart;
    }

    public function getWishList(): Wishlist {
        return $this->wishList;
    }

    /**
     * @throws Exception
     */
    public function getOrders (Orders $source): Orders { //DateTime $startDate, DateTime $endDate): Orders {
        return $source->filterByUser($this);
    }

    /**
     * @throws Exception
     */
    public function getReviews (Reviews $source): Reviews { //DateTime $startDate, DateTime $endDate): ReviewList {
        return $source->filterByUser($this); //userSearch($this, $startDate, $endDate);
    }

    public function equals ($object): bool {
        if ($object instanceof User) return parent::equals($object);
        return false;
    }
}