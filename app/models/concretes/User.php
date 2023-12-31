<?php declare(strict_types=1);

namespace app\models\concretes;


use app\models\abstracts\Person;

use DateTime;

class User extends Person {

    private CreditCardList $cards;
    private WishList $wishes;

    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        DateTime $birthdate,
        Phone $phone,
        EmailAddress $email,
        string $password,
        PostalAddress $postalAddress
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
    }

    public function getCreditCards (): CreditCardList {
        return $this->creditCards;
    }

    public function getWishes(): WishList {
        return $this->wishes;
    }

    public function getInvoices (DateTime $startDate, DateTime $endDate): InvoiceList {
        return InvoiceCatalog::userSearch($this, $startDate, $endDate);
    }

    public function getReviews (DateTime $startDate, DateTime $endDate): ReviewList {
        return ReviewsCatalog::search($this, $startDate, $endDate);
    }

    public function equals ($object): bool {
        if ($object instanceof Customer) return parent::equals($object);
        return false;
    }
}