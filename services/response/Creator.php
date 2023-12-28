<?php

namespace services\response;

use DateTime;
use Exception;
use global\DBConnect;
use global\IdGenerator;
use model\concretes\Invoice;
use models\concretes\CreditCard;
use models\concretes\Customer;
use models\concretes\Pastry;
use models\concretes\Review;
use models\factories\Factory;

class Creator extends Response {
    
    
    /**
     * @throws Exception
     */
    public static function creditCard (
        Customer $customer,
        string $cardNumber,
        DateTime $cardExpiration,
        string $cvn
    ): CreditCard {
        $dateString = $cardExpiration->format('Y-m-d');
        $cardId = IdGenerator::nextCreditCardId();
        $customerId = $customer->getid();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.credit_card  (id, customer_id, number, expiration_date, cvn) VALUES (?, ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iisss',  $cardId, $customerId, $cardNumber, $dateString, $cvn);
        $stmt->execute();
        $mysqli->close();
        return new CreditCard($cardId, $cardNumber, $cardExpiration, $cvn);
    }
    
    
    /**
     * @throws Exception
     */
    public static function review (Customer $customer, Pastry $pastry, int $rating, string $comment): Review {
        $reviewId = IdGenerator::nextReviewId();
        $customerId = $customer->getId();
        $pastryId = $pastry->getId();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.review (id, customer_id, pastry_id, rating, comment) '
            . ' VALUES (?, ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiiis', $wishId, $customerId, $pastryId, $rating, $comment);
        $stmt->execute();
        $mysqli->close();
        return new Review($reviewId, $customer, $pastry, $rating, $comment);
    }
    
    
    /**
     * @throws Exception
     */
    public static function invoice (Customer $customer, CreditCard $card): Invoice {
        $invoiceId = IdGenerator::nextInvoiceId();
        $customerId = $customer->getId();
        $cardId = $card->getId();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.invoice (id, customer_id, card_id) VALUES (?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iii', $invoiceId, $customerId, $cardId);
        $stmt->execute();
        $mysqli->close();
        return new Invoice($invoiceId, $customer, $card);
    }
    
    
    /**
     * @throws Exception
     */
    public static function wish (Customer $customer, Pastry $pastry): Wish {
        $wishId = IdGenerator::nextWishId();
        $customerId = $customer->getId();
        $pastryId = $pastry->getId();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.wishlist (id, customer_id, pastry_id) VALUES (?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iii', $wishId, $customerId, $pastryId);
        $stmt->execute();
        $mysqli->close();
        return new Wish($wishId, $pastry);
    }
    
    
    /**
     * @throws Exception
     */
    public function pastry (
        string $name,
        string $description,
        string $imageName,
        float $price
    ): Pastry {
        $pastryId = IdGenerator::nextPastryId();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.pastry (id, name, description, image_name, price) VALUES (?, ?, ?, ?, ?);';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('isssd', $pastryId, $name, $description, $imageName, $price);
        $stmt->execute();
        $mysqli->close();
        return new Pastry($pastryId, $name, $description, $imageName, $price);
    }
    
    
    /**
     * @throws Exception
     */
    public static function customer (
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
        string $cardNumber,
        DateTime $cardExpiration,
        string $cvn
    ): Customer {
        $customer = Factory::buildCustomer(
            $firstname,
            $lastname,
            $birthdate,
            $phone,
            $email,
            $password,
            $street,
            $city,
            $state,
            $zipcode
        );
        $customerId = $customer->getId();
        $dateString = $birthdate->format('Y-m-d');
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO customer '
            . '(id, firstname, lastname, birthdate, phone, email, password, street, city, state, zipcode) '
            . 'VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param(
            'issssssssss',
            $customerId,
            $firstname,
            $lastname,
            $dateString,
            $phone,
            $email,
            $password,
            $street,
            $city,
            $state,
            $zipcode
        );
        $stmt->execute();
        $customer->getCreditCards()->add(
            Creator::creditCard(
                $customer,
                $cardNumber,
                $cardExpiration,
                $cvn
            )
        );
        $mysqli->close();
        return $customer;
    }
}