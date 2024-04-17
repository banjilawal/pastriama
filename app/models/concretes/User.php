<?php declare(strict_types=1);

namespace app\models\concretes;


use app\models\lists\Invoice;
use app\models\lists\PostalAddressList;
use app\models\singletons\ReviewsCatalog;
use app\models\abstracts\Person;

use app\models\lists\CreditCardList;
use app\models\lists\Orders;
use App\models\lists\ReviewList;
use app\models\singletons\OrdersCatalog;
use app\models\lists\Wishes;
use DateTime;
use Exception;

class User extends Person {

    private Wishes $wishes;
    private Invoice $shoppingCart;
    private CreditCardList $creditCards;
    private PostalAddressList $shippingAddresses;

    /**
     * @throws Exception
     */
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        DateTime $birthdate,
        Phone $phone,
        EmailAddress $email,
        string $password,
        PostalAddress $billingAddress,
        CreditCard $creditCard
    ) {
        parent::__construct(
            $id,
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $email,
            $password,
            $billingAddress
        );
        $this->shippingAddresses = new PostalAddressList();
        $this->creditCards = new CreditCardList();
        $this->shoppingCart = new Invoice();
        $this->wishes = new Wishes();

        $this->shippingAddresses->setPrimaryShippingAddress($billingAddress);
        $this->creditCards->add($creditCard);
    }

    public function getBillingAddress (): PostalAddress {
        return $this->getPostalAddress();
    }

    public function getShippingAddresses (): PostalAddressList {
        return $this->shippingAddresses;
    }

    public function getCreditCards (): CreditCardList {
        return $this->creditCards;
    }

    public function getShoppingCart (): Invoice {
        return $this->shoppingCart;
    }

    public function getWishes(): Wishes {
        return $this->wishes;
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
    public function getReviews (ReviewList $source): ReviewList { //DateTime $startDate, DateTime $endDate): ReviewList {
        return $source->filterByUser($this); //userSearch($this, $startDate, $endDate);
    }

    public function equals ($object): bool {
        if ($object instanceof User) return parent::equals($object);
        return false;
    }
}