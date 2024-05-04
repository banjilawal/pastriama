<?php

namespace app\services\requests\requests;

use app\enums\CreditCardProvider;
use app\enums\MailingCategory;
use app\enums\State;
use app\models\concretes\CreditCard;
use app\models\concretes\Email;
use app\models\concretes\Phone;
use app\models\concretes\PostalAddress;
use app\models\concretes\Zipcode;
use app\utils\Convert;
use app\utils\SerialNumber;
use DateTime;

class RegisterAccountRequest {
    private string $firstname;
    private string $lastname;
    private DateTime $birthdate;
    private Phone $phone;
    private Email $emailAddress;
    private string $password;
    private PostalAddress $postalAddress;
    private CreditCard $creditCard;

    /**
     * @param string $firstname
     * @param string $lastname
     * @param DateTime $birthdate
     * @param string $phoneString
     * @param string $emailAddressString
     * @param string $password
     * @param string $street
     * @param string $city
     * @param string $statePostalCode
     * @param string $mailingAddressCategory
     * @param string $zipcodeString
     * @param string $cardProvider
     * @param string $nameOnCard
     * @param string $number
     * @param string $cvn
     * @param int $expirationMonth
     * @param int $expirationYear
     * @throws \Exception
     */
    public function __construct (
        string $firstname,
        string $lastname,
        DateTime $birthdate,
        string $phoneString,
        string $emailAddressString,
        string $password,
        string $street,
        string $city,
        string $statePostalCode,
        string $zipcodeString,
        string $mailingAddressCategory,
        string $cardProvider,
        string $nameOnCard,
        string $number,
        string $cvn,
        int $expirationMonth,
        int $expirationYear
    ) {
        $this->firstname = sanitize_input($firstname);
        $this->lastname = sanitize_input($lastname);
        $this->birthdate = $birthdate;
        $this->phone = Convert::stringToPhone(sanitize_input($phoneString));
        $this->emailAddress = Convert::stringToEmailAddress(sanitize_input($emailAddressString));
        $this->password = sanitize_input($password);

        $this->postalAddress = new PostalAddress(
            sanitize_input($street),
            sanitize_input($city),
            State::from(sanitize_input($statePostalCode)),
            new Zipcode(sanitize_input($zipcodeString)),
            MailingCategory::from(sanitize_input($mailingAddressCategory))
        );

        $this->creditCard = new CreditCard(
            SerialNumber::nextCreditCardId(),
            CreditCardProvider::from(sanitize_input($cardProvider)),
            sanitize_input($nameOnCard),
            sanitize_input($number),
            DateTime::createFromFormat('Y/m', $expirationYear . '/' . $expirationMonth),
            sanitize_input($cvn)
        );;
    }

    public function getFirstname (): string {
        return $this->firstname;
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

    public function getEmailAddress (): Email {
        return $this->emailAddress;
    }

    public function getPassword (): string {
        return $this->password;
    }

    public function getPostalAddress (): PostalAddress {
        return $this->postalAddress;
    }

    public function getCreditCard (): CreditCard {
        return $this->creditCard;
    }
}