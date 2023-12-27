<?php
namespace models\concretes;

use Exception;
use global\Validate;
use model\abstract\Person;
use model\abstract\Order;

use models\containers\Orders;
use models\containers\Reviews;
use models\containers\WishLists;

class Customer extends Person {
    private array $creditCards;
    
    
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        PostalAddress $postalAddress,
        string $emailAddress, //EmailAddress $emailAddress,
        Phone $phone,
//        CreditCard $creditCard
    ) {
        parent::__construct($id, $firstname, $lastname, $postalAddress, $emailAddress, $phone);
        $this->creditCards = array();
//        $this->creditCards[$creditCard->getNumber()] = $creditCard;
    }

//
//    /**
//     * @throws Exception
//     */
//    public function createCreditCard (string $cardNumber, \DateTime $expirationDate, string $cvn): void {
//        $creditCard = new CreditCard($this->getFirstname(), $this->getLastname(), $cardNumber, $expirationDate, $cvn);
//        if (array_key_exists($cardNumber, $this->creditCards)) {
//            throw new Exception('A card with id ' . $cardNumber . ' is already in the list');
//        }
//        $this->creditCards[$cardNumber] = $creditCard;
//    }


    public function addCreditCard (CreditCard $card): void {
        $id = $card->getId();
        if (array_key_exists($id, $this->creditCards)) {
            throw new Exception('A card with id ' . $id . ' is already in the list');
        }
        $this->creditCards[$id] = $card;
    }


    public function searchCreditCards (String $cardNumber): ?CreditCard {
        foreach ($this->creditCards as $creditCard) {
            if ($creditCard->getNumber() === $cardNumber)
                return $creditCard;
        }
        return null;
    } // close search
    

    public function printCreditCards (): string {
        $string = '(Cards: ';
        foreach ($this->creditCards as $id => $card) {
            $string  .= $this->creditCards[$id] . ',';
        }
        $string = trim($string, ",");
        $string .= ' )';
        return $string;
    } // close toString


    public function creditCardsTable (): string {
        $elem = '<table class="table" name="credit-cards-table" id="credit-cards-table">'
            . '<thead>'
            . '<tr>'
            . '<th hidden>ID/th>'
            . '<th>Card Number</th>'
            . '<th>Expiration</th>'
            . '<th>CVN</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->creditCards as $id => $card) {
            $elem .= $this->creditCards[$id]->to_row();
        }
        $elem .= '<tbody></table>';
        return $elem;
    } // close to_table



    public function creditCardSelector (): string {
        $elem = '<label for="card">Credit Card</label><br>'
            . '<select id="card" name="card">'
            . '<option value="">-- Select Your Payment Method --</option>';
        foreach ($this->creditCards as $id => $card) {
            $elem .= '<option value="' . $id . '">' . $this->creditCards[$id] . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    } // close to_selector
    

    public function getOrders (\DateTime $startDate, \DateTime $endDate): array {
        $matches = array();
        foreach (Orders::getOrders() as $order) {
            if ($order->getCustomer() === $this && $order->getSubmitTime() >= $startDate && $order->getSubmitTime() <= $endDate)
                $matches[] = $order;
        }
        return $matches;
    }

    
    public function ordersToTable (\DateTime $startDate, \DateTime $endDate): string {
        $tableName = $this->getId() . '-order-table-'. $startDate->format('Y-m-d') . '-' .$endDate->format('Y-m-d');
        $elem = '<table class="customer-orders-table" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>Order Id</th>'
            . '<th>Submit Time</th>'
            . '<th>Estimated Delivery</th>'
            . '<th>Total Charge</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->getOrders($startDate, $endDate) as $order) {
            $elem .= $order->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
    
    
    public function getWishList (\DateTime $startDate, \DateTime $endDate): array {
        $matches = array();
        foreach (WishLists::getWishLists() as $wishList) {
            if ($wishList->getCustomer() === $this && $wishList->getSubmitTime() >= $startDate && $wishList->getSubmitTime() <= $endDate)
                $matches[] = $wishList;
        }
        return $matches;
    }
    
    
    public function wishListToTable (\DateTime $startDate, \DateTime $endDate): string {
        $tableName = $this->getId() . '-wishList-table-'. $startDate->format('Y-m-d') . '-' .$endDate->format('Y-m-d');
        $elem = '<table class="customer-wishList-table" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th></th>'
            . '<th>Date Added</th>'
            . '<th>Picture</th>'
            . '<th>Name</th>'
            . '<th>Description</th>'
            . '<th>Price</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->getWishList($startDate, $endDate) as $wishListItem) {
            $elem .= $wishListItem->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }
    
    
    public function getRatings (\DateTime $startDate, \DateTime $endDate): array {
        $matches = array();
        foreach (Reviews::getReviews() as $rating) {
            if ($rating->getCustomer() === $this && $rating->getSubmitTime() >= $startDate && $rating->getSubmitTime() <= $endDate)
                $matches[] = $rating;
        }
        return $matches;
    }
    
    
    public function ratingsToTable (\DateTime $startDate, \DateTime $endDate): string {
        $tableName = $this->getId() . '-order-table-'. $startDate->format('Y-m-d') . '-' .$endDate->format('Y-m-d');
        $elem = '<table class="customer-orders-table" id="' . $tableName . '" name="' . $tableName . '">'
            . '<thead>'
            . '<tr>'
            . '<th>Order Id</th>'
            . '<th>Date</th>'
            . '<th>Reviewer</th>'
            . '<th>Pastry</th>'
            . '<th>Stars</th>'
            . '<th>Comment</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->getRatings($startDate, $endDate) as $rating) {
            $elem .= $rating->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }


    public function equals ($object): bool {
        if ($object instanceof Customer) return parent::equals($object);
        return false;
    }
} // end class Customer