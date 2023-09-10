<?php
namespace models\concretes;

use global\Validate;
use model\abstract\Person;
use models\containers\IntegerBag;

class Customer extends Person {
    private IntegerBag $order_ids;
    private IntegerBag $card_ids;
    private IntegerBag $review_ids;
    
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        PostalAddress $postalAddress,
        EmailAddress $emailAddress,
        Phone $phone
    ) {
        parent::__construct($id, $firstname, $lastname, $postalAddress, $emailAddress, $phone);
        $this->order_ids = new IntegerBag();
        $this->card_ids = new IntegerBag();
        $this->review_ids = new IntegerBag();
    }
    
    public function get_order_ids (): array {
        return $this->order_ids;
    }
    
    public function get_card_ids (): array {
        return $this->card_ids;
    }
    
    public function get_review_ids (): array {
        return $this->review_ids;
    }
    
    public function add_order_id (int $order_id): void {
        $this->order_ids->add($order_id);
    }
    
    public function add_card_id (int $card_id): void {
        $this->card_ids->add($card_id);
    }
    
    public function add_review_id (int $review_id): void {
        $this->review_ids->add($review_id);
    }
    
    public function equals ($object): boolean {
        if ($object instanceof Customer) return parent::equals($object);
        return false;
    }
    
    public function __toString (): string {
        return parent::__toString();
    }
} // end class Customer