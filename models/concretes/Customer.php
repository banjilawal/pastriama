<?php
namespace models\concretes;

use global\Validate;
use model\abstract\Person;
use models\containers\CreditCardBag;

class Customer extends Person {
    private CreditCardBag $credit_cards;
    
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        PostalAddress $postalAddress,
        EmailAddress $emailAddress,
        Phone $phone)  {
        parent::__construct(
            $id,
            $firstname,
            $lastname,
            $postalAddress,
            $emailAddress,
            $phone
        );
        $this->credit_cards = new CreditCardBag();
    } //
    
    public function get_credit_cards (): CreditCardBag {
        return $this->credit_cards;
    }
    
    public function set_credit_cards (CreditCardBag $credit_cards): void {
        $this->credit_cards = $credit_cards;
    }
    
    
} //  end class