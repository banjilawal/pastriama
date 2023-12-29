<?php
namespace models\abstracts;


use DateTime;
use exceptions\EmptyStringException;
use global\Validate;
use models\abstracts\NamedEntity;
use models\concretes\EmailAddress;
use models\concretes\Phone;
use models\concretes\PostalAddress;

require_once('vendor\autoload.php');

abstract class Person extends NamedEntity {
    private string $lastname;
    private DateTime $birthdate;
    private Phone $phone;
    private EmailAddress $email;
    private string $password;
    private PostalAddress $postalAddress;
    
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
        parent::__construct($id, $firstname);
        $this->lastname = $firstname; // Validate::non_empty_string($lastname, 'Person', 'lastname', 26);
        $this->birthdate = $birthdate;
        $this->phone = $phone;
        $this->email = $email;
        $this->password = $password;
        $this->postalAddress = $postalAddress;
    }
    
    public function getFirstname (): string {
        return $this->getName();
    }
    
    
    public function getLastname (): string {
        return $this->lastname;
    }
    
    public function getBirthdate (): DateTime {
        return $this->birthdate;
    }
    
    
    public function getPhone (): Phone {
        return $this->phone;
    }
    
    
    public function getEmail (): string {
        return $this->email;
    }
    
    
    public function getPassword (): string {
        return $this->password;
    }
    
    
    public function getPostalAddress (): PostalAddress {
        return $this->postalAddress;
    }
    
    
    public function setFirstname (string $firstname): void {
        $this->setName($firstname);
    }
    
    
    public function setLastname (string $lastname): void {
        $this->lastname = $lastname; //Validate::non_empty_string($lastname, 'Person', 'lastname', 43);
    }
    
    public function setBirthdate (DateTime $birthdate): void {
        $this->birthdate = $birthdate;
    }
    
    
    public function setPhone (Phone $phone): void {
        $this->phone = $phone;
    }
    
    
    public function setEmails (EmailAddress $email): void {
        $this->email = $email;
    }
    
    
    public function setPassword (string $password): void {
        $this->password = $password;
    }
    
    public function setPostalAddress (PostalAddress $postalAddress): void {
        $this->postalAddress = $postalAddress;
    }
    
    
    public function equals ($object): bool {
        if ($this === $object) return true;
        if (is_null($object)) return false;
        if ($object instanceof Person) {
            return parent::equals($object)
                && $this->lastname === $object->getLastname()
                && $this->birthdate === $object->getBirthdate()
                && $this->postalAddress->equals($object->getPostalAddress())
                && $this->email->equals($object->getEmail())
                && $this->phone->equals($object->getPhone());
        }
        return false;
    }
    
    
    public function __toString (): string {
        return $this->getId()
            . ' firstname:' . $this->getFirstname()
            . ' lastname:' . $this->lastname
            . ' birthdate:' . $this->birthdate->format('Y-m-d')
            . ' phone:' . $this->phone
            . ' email:' . $this->email
            . ' postal address:' . $this->postalAddress;
    }
} // end class Person