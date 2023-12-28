<?php

namespace models\factories;

use DateTime;
use Exception;
use exceptions\EmptyStringException;
use global\IdGenerator;
use models\concretes\Customer;
use models\concretes\Domain;
use models\concretes\EmailAddress;
use models\concretes\Phone;
use models\concretes\PostalAddress;
use models\concretes\State;
use models\concretes\Zipcode;

class Factory {
    
    /**
     * @throws Exception
     */
    public static function buildPhone (string $string): Phone {
        $areaCode = substr($string, (strpos($string,'(') + 1 ),  (strpos($string,')') - 1 ) );
        $exchange = substr($string, (strpos($string,' ') + 1 ),  (strpos($string,')') - 1 ) );
        $number = substr($string, (strpos($string,'-') + 1 ) );
        return new Phone($areaCode, $exchange, $number);
    }
    
    
    /**
     * @throws EmptyStringException
     */
    public static function buildEmail (string $string): EmailAddress {
        $array = explode('@', $string);
        $mailbox = $array[0];
        $domainParts = explode('.', $array[1]);
        $name = implode(array_slice($domainParts, (sizeof($domainParts) - 1)));
        $tld = $domainParts[(sizeof($domainParts) - 1)];
        return new EmailAddress($mailbox, new Domain($name, $tld));
    }
    
    /**
     * @throws Exception
     */
    public static function buildPostalAddress (
        string $street,
        string $city,
        string $state,
        string $zipcode
    ): PostalAddress {
        return new PostalAddress($street, $city, new State($state), new Zipcode($zipcode));
    }
    
    
    /**
     * @throws Exception
     */
    public static function buildCustomer (
        string $firstname,
        string $lastname,
        Datetime $birthdate,
        string $phone,
        string $email,
        string $password,
        string $street,
        string $city,
        string $state,
        string $zipcode,
    ): Customer {
        $postalAddress = new PostalAddress($street, $city, (new State($state)), (new Zipcode($zipcode)));
        return new Customer(
            IdGenerator::nextCustomerId(),
            $firstname,
            $lastname,
            $birthdate,
            Factory::buildPhone($phone),
            Factory::buildEmail($email),
            $password,
            Factory::buildPostalAddress($street, $city, $state, $zipcode)
        );
    }
} // end class