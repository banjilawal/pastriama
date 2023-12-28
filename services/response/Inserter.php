<?php

namespace services\response;

use DateTime;
use Exception;
use global\DBConnect;
use global\IdGenerator;
use model\concretes\Invoice;
use models\concretes\CreditCard;
use models\concretes\Customer;
use models\concretes\InvoiceItem;
use models\concretes\Pastry;
use models\concretes\Review;
use models\factories\Factory;

class Inserter extends Response {

    /**
     * @throws Exception
     */
    public static function insertReview (Review $review): void {
        $reviewId = $review->getId();
        $customerId = $review->getCustomer->getId();
        $pastryId = $review->getPastry()->getId();
        $rating = $review->getRating();
        $comment = $review->getComment();
        $submissionTime = $review->getSubmissionTime()->format('Y-m-d H:i:s');
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.review (id, customer_id, pastry_id, rating, comment, submission_time) '
            . ' VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiiisss', $wishId, $customerId, $pastryId, $rating, $comment, $submissionTime);
        $stmt->execute();
        $mysqli->close();
    }


    /**
     * @throws Exception
     */
    public static function invoiceItem  (int $invoiceId, InvoiceItem $item): void {
        $itemId = $item->getId();
        $quantity = $item->getQuantity();
        $pastryId = $item->getPastry()->getId();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.invoice_item (id, invoice_id, pastry_id, $quantity) '
            . ' VALUES (?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiii', $invoiceItemId, $invoiceId, $pastryId, $quantity);
        $stmt->execute();
        $mysqli->close();
    }


    /**
     * @throws Exception
     */
    public static function insertInvoice  (Invoice $invoice, Pastry $pastry, int $quantity): void {
        $invoiceId = $invoice->getId();
        $customerId = $invoice->getCustomer()-getId();
        $cardId = $invoice->getCard()->getId();
        $submissionTime = $invoice->getSubmissionTime()->format('Y-m-d H:i:s');
        $projectedDelivery = $invoice->getProjectedDelivery()->format('Y-m-d H:i:s');
        $subtotal = $invoice->getSubTotal();
        $tax = $invoice->getTax();
        $total = $invoice->getTotal();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.invoice_item (id, customer_id, card_id, submission_time, '
            . 'projected_delivery, subtotal, tax, total, pastry_id) '
            . 'VALUES (?, ?, ?, ?,  ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param(
            'iiissiii',
            $invoiceId,
            $customerId,
            $cardId,
            $submissionTime,
            $projectedDelivery,
            $subtotal,
            $tax,
            $total
        );
        $stmt->execute();
        $mysqli->close();
        foreach($invoice->getItems() as $id => $item) {
            insertInvoiceItem($invoiceId, $item);
        }
    }

    
    
    /**
     * @throws Exception
     */
    public static function insertWish (int $customerId, Wish $wish): void {
        $wishId = $wish->getId();
        $pastryId = $wish->getPastry()->getId();
        $submissionTime = $wish->getSubmissionTime()->format('Y-m-d H:i:s');
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.wishlist (id, customer_id, pastry_id, submission_time) VALUES (?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iiis', $wishId, $customerId, $pastryId, $submissionTime);
        $stmt->execute();
        $mysqli->close();
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
    public function insertPastry (Pastry $pastry): void {
        $id = $pastry->getId();
        $name = $pastry->getName();
        $description = $pastry->getDescription(;
        $imageName = $pastry->getImageName();
        $price = $pastry->getPrice();
        $pastryId = IdGenerator::nextPastryId();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.pastry (id, name, description, image_name, price) VALUES (?, ?, ?, ?, ?);';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('isssd', $id, $name, $description, $imageName, $price);
        $stmt->execute();
        $mysqli->close();
    }


    /**
     * @throws Exception
     */
    public static function insetCreditCard (int $customerId, Card $card): void {
        $cardId = $card->getId();
        $number = $card->getNumber();
        $expiration = $card->getExpiration()->format('Y-m-d');
        $cvn = $card->getCVN();
        $mysqli = DBConnect::connect();
        $query = 'INSERT INTO bakery.credit_card  (id, customer_id, number, expiration, cvn) VALUES (?, ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iisss',  $cardId, $customerId, $number, $expiration, $cvn);
        $stmt->execute();
        $mysqli->close();
    }
    
    
    /**
     * @throws Exception
     */
    public static function insertCustomer (
        Customer $customer
//        string $firstname,
//        string $lastname,
//        Datetime $birthdate,
//        string $phone,
//        string $email,
//        string $password,
//        string $street,
//        string $city,
//        string $state,
//        string $zipcode,
//        string $cardNumber,
//        DateTime $cardExpiration,
//        string $cvn
    ): void {
//        $customer = Factory::buildCustomer(
//            $firstname,
//            $lastname,
//            $birthdate,
//            $phone,
//            $email,
//            $password,
//            $street,
//            $city,
//            $state,
//            $zipcode
//        );
        $customerId = $customer->getId();
        $firstname = $customer->getFirstname();
        $lastname = $customer->getLastname();
        $birthdate = $customer->getBirthdate()->format('Y-m-d');
        $phone = $customer->getPhone()->toString();
        $email = $customer->getEmail()->toString();
        $password = $customer->getPassword;
        $street = $customer->getPostalAddress()->getStreet();
        $city = $customer->getPostalAddress()->getCity();
        $state = $customer->getPostalAddress()->getState()->getAcronym();,
        $zipcode = $customer->getPostalAddress()->getZipcode();
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
        $mysqli->close();
        foreach($customer->getCreditCards() as $id => $card) {
            inserCreditCard($customerId, $card);
        }
        foreach($customer->getWishes() as $id => $wish) {
            self::insertWish($customerId, $wish);
        }
    }
}