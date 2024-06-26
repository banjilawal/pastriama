<?php declare(strict_types=1);

namespace app\models\abstracts;

use app\models\concretes\Email;
use app\Models\Concretes\Phone;
use app\models\concretes\PostalAddress;
use DateTime;
use Exception;

abstract class Person extends NamedEntity {
    private string $lastname;
    private DateTime $birthdate;
    private Phone $phone;
    private Email $email;
    private string $password;
    private PostalAddress $postalAddress;

    /**
     * @param int $id
     * @param string $firstname
     * @param string $lastname
     * @param DateTime $birthdate
     * @param Phone $phone
     * @param Email $email
     * @param string $password
     * @param PostalAddress $postalAddress
     * @throws Exception
     */
    public function __construct (
        int $id,
        string  $firstname,
        string $lastname,
        DateTime $birthdate,
        Phone $phone,
        Email $email,
        string $password,
        PostalAddress $postalAddress
    ) {
        parent::__construct($id, $firstname);
        $this->lastname = $lastname;
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

    public function getEmail (): Email {
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
        $this->lastname = $lastname;
    }

    public function setBirthdate (DateTime $birthdate): void {
        $this->birthdate = $birthdate;
    }

    public function setPhone (Phone $phone): void {
        $this->phone = $phone;
    }

    public function setEmails (Email $email): void {
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
                && $this->phone->equals($object->getPhone())
//                && $this->email->equals($object->getEmail())
                && $this->postalAddress->equals($object->getPostalAddress());
        }
        return false;
    }

    public function printName (): string {
        return $this->getFirstname() . ' ' . $this->lastname;
    }

    public function __toString (): string {
        return 'id:' . $this->getId() // . '<br>' . PHP_EOL
            . ' name:' . $this->printName() // . '<br>' . PHP_EOL
            . ' birthdate:' . $this->birthdate->format('Y-m-d') //. '<br>' . PHP_EOL
            . ' phone:' . $this->phone //.'<br>' . PHP_EOL
            . ' email:' . $this->email //.'<br>' . PHP_EOL
            . ' postal address:' . $this->postalAddress; // .'<br>' . PHP_EOL;
    }

    public function toRow (): string {
        return '<tr id="' . $this->getId() . '">' // onclick="get_item(this)">'
            . '<td>' . $this->printName() . '</td>'
            . '<td>' . $this->phone .'</td>'
            . '<td>' . $this->email . '</td>'
            . '<td>' . $this->postalAddress . '</td>'
            . '</tr>';
    }
}