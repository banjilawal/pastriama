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
    
    public function getFirstname (): string { return $this->getName(); }
    public function getLastname (): string { return $this->lastname; }
    public function getPostalAddress (): PostalAddress { return $this->postalAddress; }
    public function getEmailAddress (): EmailAddress { return $this->emailAddress; }
    public function getPhone (): Phone { return $this->phone; }
    
    /**
     * @throws EmptyStringException
     */
    public function setFirstname (string $firstname): void { $this->setName($firstname); }
    
    /**
     * @throws EmptyStringException
     */
    public function setLastname (string $lastname): void {
        $this->lastname = Validate::non_empty_string($lastname, 'Person', 'lastname', 43);
    }
    
    public function setPostalAddress (PostalAddress $postalAddress): void { $this->postalAddress = $postalAddress; }
    public function setEmailAddress (EmailAddress $emailAddress): void { $this->emailAddress = $emailAddress; }
    public function setPhone (Phone $phone): void { $this->phone = $phone; }
    
    public function equals ($object): boolean {
        if ($object instanceof Person) {
            return parent::equals($object)
                && $this->lastname === $object->getLastname()
                && $this->postalAddress->equals($object->getPostalAddress())
                && $this->emailAddress->equals($object->getEmailAddress())
                && $this->phone->equals($object->getPhone());
        }
        return false;
    }
    
    public function __toString (): string {
        return $this->getId()
            . ' firstname:' . $this->getFirstname()
            . ' lastname:' . $this->lastname
            . ' postal address:' . $this->postalAddress
            . ' email:' . $this->emailAddress
            . ' phone:' . $this->phone;
    }
} // end class Person