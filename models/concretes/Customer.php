<?php
namespace models\concretes;

use DateTime;
use Exception;
use global\Validate;

use model\abstracts\Person;
use models\singletons\InvoicesCatalog;
use models\singletons\ReviewsCatalog;
use Shop\Model\collections\CreditCardList;
use Shop\Model\collections\InvoiceList;
use Shop\Model\collections\ReviewList;
use Shop\Model\collections\WishList;

class Customer extends Person {
    private CreditCardList $creditCards;
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


    /**
     * @throws Exception
     */
    public function getInvoices (DateTime $startDate, DateTime $endDate): InvoiceList {
        return InvoicesCatalog::search($this, $startDate, $endDate);
    }


    public function getReviews (DateTime $startDate, DateTime $endDate): ReviewList {
        return ReviewsCatalog::search($this, $startDate, $endDate);
    }


    public function equals ($object): bool {
        if ($object instanceof Customer) return parent::equals($object);
        return false;
    }
} // end class Customer