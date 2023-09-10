<?php
namespace model\abstract;

use exceptions\EmptyStringException;
use global\Validate;
use model\abstract\NamedEntity;
use models\concretes\EmailAddress;
use models\concretes\Phone;
use models\concretes\PostalAddress;

abstract class Person extends NamedEntity {
    private string $lastname;
    private PostalAddress $postalAddress;
    private EmailAddress $emailAddress;
    private Phone $phone;
    
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        PostalAddress $postalAddress,
        EmailAddress $emailAddress,
        Phone $phone
    ) {
        parent::__construct($id, $firstname);
        $this->lastname = Validate::non_empty_string($lastname, 'Person', 'lastname', 26);
        $this->postalAddress = $postalAddress;
        $this->emailAddress = $emailAddress;
        $this->phone = $phone;
    }
    
    public function get_firstname (): string { return $this->get_name(); }
    public function get_lastname (): string { return $this->lastname; }
    public function get_postal_address (): PostalAddress { return $this->postalAddress; }
    public function get_email_address (): EmailAddress { return $this->emailAddress; }
    public function get_phone (): Phone { return $this->phone; }
    
    /**
     * @throws EmptyStringException
     */
    public function set_firstname (string $firstname): void { $this->set_name($firstname); }
    
    /**
     * @throws EmptyStringException
     */
    public function set_lastname (string $lastname): void {
        $this->lastname = Validate::non_empty_string($lastname, 'Person', 'lastname', 43);
    }
    
    public function set_postal_address (PostalAddress $postalAddress): void { $this->postalAddress = $postalAddress; }
    public function set_email_address (EmailAddress $emailAddress): void { $this->emailAddress = $emailAddress; }
    public function set_phone (Phone $phone): void { $this->phone = $phone; }
    
    public function equals ($object): boolean {
        if ($object instanceof Person) {
            return parent::equals($object)
                && $this->lastname === $object->get_lastname()
                && $this->postalAddress === $object->get_postal_address()
                && $this->emailAddress === $object->get_email_address()
                && $this->phone == $object->get_phone();
        }
        return false;
    }
    
    public function __toString (): string {
        return $this->get_id()
            . ' firstname:' . $this->get_firstname()
            . ' lastname:' . $this->lastname
            . ' postal address:' . $this->postalAddress
            . ' email:' . $this->emailAddress
            . ' phone:' . $this->phone;
    }
} // end class Person