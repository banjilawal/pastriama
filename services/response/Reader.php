<?php

namespace services\response;

use DateTime;
use global\DBConnect;
use global\IdGenerator;
use models\concretes\CreditCard;
use models\concretes\Customer;
use models\concretes\InvoiceItem;
use models\concretes\Pastry;
use models\concretes\PostalAddress;
use models\concretes\Review;
use models\concretes\State;
use models\concretes\Zipcode;
use models\factories\Factory;
use models\singletons\InvoicesCatalog;
use models\singletons\ReviewsCatalog;
use services\request\CreditCardsQueryRequest;
use services\request\CustomerQueryRequest;
use services\request\OrderItemQueryRequest;
use services\request\OrdersQueryRequest;
use services\request\ReviewsQueryRequest;

class Reader extends Response {
    /**
     * @throws \Exception
     */
    public static function customerQuery (CustomerQueryRequest $request): Customer {
        $id = null;
        $firstname = null;
        $lastname = null;
        $birthdate = null;
        $phone = null;
        $streetNumber = null;
        $city = null;
        $state = null;
        $zipcode = null;
        $customer = null;
        $email = $request->getEmail();
        $password = $request->getPassword();
        
        $mysqli = DBConnect::connect();
        $query = 'SELECT c.id, firstname, lastname, birthdate, phone, '
            . 'street, city, state, zip FROM shop.customer u '
            . 'INNER JOIN shop.creditCard c ON u.id = c.customerId '
            . 'WHERE c.email = ? AND password = ?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $stmt->bind_result($id, $firstname, $lastname, $birthdate, $phone, $streetNumber, $city, $state, $zipcode);
        while ($stmt->fetch()) {
            $postalAddress = new PostalAddress($streetNumber, $city, (new State($state)), (new Zipcode($zipcode)));
            $request = new CreditCardsQueryRequest(new Customer((int) $id, $firstname, $lastname, $postalAddress, $email, Factory::buildPhone($phone)));
            $customer = Reader::creditCardsQuery($request);
        }
        $mysqli->close();
        return $customer;
    }
    
    
    /**
     * @throws \Exception
     */
    public static function orderItemsQuery (OrderItemQueryRequest $request) : Invoice {
        $orderItemId = null;
        $pastryId = null;
        $pastryName = null;
        $pastryPrice = null;
        $pastryQuantity = null;
        $pastryImageName = null;
        $pastryDescription = null;
        $orderId = $request->getOrder()->getId();
        
        $mysqli = DBConnect::connect();
        $query = 'SELECT '
            . 'i.id orderIemId, i.quantity, i.pastryId, p.name, p.description, p.price '
            . 'FROM order o INNER JOIN order_item i INNER JOIN pastry p '
            . 'ON i.pastryId = p.id ON i.orderId = o.id WHERE o.id = ?;';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $orderId);
        $stmt->execute();
        $stmt->bind_result($orderItemId, $pastryQuantity, $pastryId, $pastryName, $pastryImageName, $pastryDescription, $pastryPrice);
        while ($stmt->fetch()) {
            $pastry = new Pastry((int) $pastryId, $pastryName, (float) $pastryPrice, $pastryImageName, $pastryDescription);
            $orderItem = new InvoiceItem($pastry, (int)$pastryQuantity);
            $request->getOrder()->getInvoiceItems()->addItem($orderItem);
        }
        $mysqli->close();
        return $request->getOrder();
    }
    
    
    /**
     * @throws \Exception
     */
    public static function creditCardsQuery (CreditCardsQueryRequest $request) : Customer {
        $cardId = null;
        $cvn = null;
        $number = null;
        $expirationDate = null;
        $customerId = $request->getCustomer()->getId();
        
        $mysqli = DBConnect::connect();
        $query = 'SELECT '
            . 'c.id, c.cvn, c.number, c.expirationDate '
            . 'FROM customer u INNER JOIN creditCard c '
            . 'ON u.id = c.customerId WHERE u.id = ?;';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $customerId);
        $stmt->execute();
        $stmt->bind_result( $cardId, $cvn, $number, $expirationDate);
        while ($stmt->fetch()) {
            $card = new CreditCard((int) $cardId, $number, DateTime::createFromFormat('Y-m', $expirationDate),$cvn);
            $request->getCustomer()->addCreditCard($card);
        }
        $mysqli->close();
        return $request->getCustomer();
    }
    
    
    /**
     * @throws \Exception
     */
    public static function ordersQuery (OrdersQueryRequest $request) : array {
        $orderId = null;
        $timestamp = null;
        $deliveryDate = null;
        $cardNumber = null;
        $cardCVN = null;
        $cardExpiration = null;
        $customer = $request->getCustomer();
        $customerId = $customer->getId();
        $startDate = $request->getStartDate();
        $endDate = $request->getEndDate();

        $mysqli = DBConnect::connect();
        $query = 'SELECT '
            . 'i.quantity, o.id orderID, o.submitDate, o.actualDelivery, '
            . 'c.cvn, c.expiration, c.id cardID '
            . 'FROM order_items i INNER JOIN orders o INNER JOIN cards c '
            . 'ON o.creditCard = c.id ON i.orderId = o.id WHERE o.customerID = ? AND o.submitDate BETWEEN ? AND ?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sss', $customerId, $startDate, $endDate);
        $stmt->execute();
        $stmt->bind_result($orderId, $timestamp, $deliveryDate, $cardCVN,  $cardExpiration, $cardNumber);
        while ($stmt->fetch()) {
            $submitTime = \DateTime::createFromFormat('Y-m-d H:i:s',$timestamp);
            $expirationDate = \DateTime::createFromFormat('Y-m',$cardExpiration);
            $actualDeliveryDate = \DateTime::createFromFormat('Y-m-d H:i:s',$deliveryDate);
            $creditCard = new CreditCard($customer->getFirstname(), $customer->getLastname(), $cardNumber, $expirationDate, $cardCVN);
            $orderItemRequest = new OrderItemQueryRequest(new Invoice((int) $orderId, $customer, $creditCard, $submitTime, $actualDeliveryDate));
            $order = Reader::orderItemsQuery($orderItemRequest);
            InvoicesCatalog::getCatalog()->add($order);
        }
        $mysqli->close();
        return InvoicesCatalog::getCatalog();
    }
    
    
    /**
     * @throws \Exception
     */
    public static function reviewsQuery (ReviewsQueryRequest $request) : array {
        $reviewId = null;
        $timestamp = null;
        $reviewComment= null;
        $reviewStars = null;
        $pastryId = null;
        $pastryName = null;
        $pastryPrice = null;
        $pastryImageName = null;
        $pastryDescription = null;
        $customer = $request->getCustomer();
        $customerId = $customer->getId();
        $startDate = $request->getStartDate();
        $endDate = $request->getEndDate();
        
        $mysqli = DBConnect::connect();
        $query = 'SELECT '
            . 'r.id reviewID, r.submitDate, r.comment, r.rating, r.pastryId, p.pastryName, p.pastryDescription '
            . 'p.pastryImageName '
            . 'FROM customer c i INNER JOIN review r INNER JOIN pastry p '
            . 'ON r.pastryId = r.id ON r.customerId = c.id WHERE c.id = ? AND r.submitDate BETWEEN ? AND ?';
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sss', $customerId, $startDate, $endDate);
        $stmt->execute();
        $stmt->bind_result($reviewId, $timestamp, $reviewComment, $reviewStars, $pastryId, $pastryName, $pastryDescription, $pastryImageName);
        while ($stmt->fetch()) {
            $submitTime = \DateTime::createFromFormat('Y-m-d H:i:s', $timestamp);
            $pastry = new Pastry((int) $pastryId, $pastryName, (float) $pastryPrice, $pastryImageName, $pastryDescription);
            ReviewsCatalog::getCatalog()->add(new Review((int) $reviewId, $customer, $pastry, (int) $reviewStars, $reviewComment));
        }
        $mysqli->close();
    }
}