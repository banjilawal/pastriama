<?php declare(strict_types=1);

namespace app\models\concretes;


use app\models\singletons\ReviewCatalog;
use app\models\abstracts\Person;

use app\models\lists\CreditCardList;
use app\models\lists\InvoiceList;
use App\models\lists\ReviewList;
use app\models\singletons\InvoiceCatalog;
use app\models\lists\WishList;
use DateTime;
use Exception;

class User extends Person {

    private CreditCardList $cards;
    private WishList $wishes;
    private CreditCardList $creditCards;

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
        PostalAddress $postalAddress,
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
            $postalAddress
        );
        $this->creditCards = new CreditCardList();
        $this->wishes = new WishList();
        $this->creditCards->add($creditCard);
    }

    public function getCreditCards (): CreditCardList {
        return $this->creditCards;
    }

    public function getWishes(): WishList {
        return $this->wishes;
    }

    /**
     * @throws Exception
     */
    public function getInvoices (DateTime $startDate, DateTime $endDate): InvoiceList {
        return InvoiceCatalog::userSearch($this, $startDate, $endDate);
    }

    public function getReviews (DateTime $startDate, DateTime $endDate): ReviewList {
        return ReviewCatalog::search($this, $startDate, $endDate);
    }

    public function equals ($object): bool {
        if ($object instanceof User) return parent::equals($object);
        return false;
    }
}