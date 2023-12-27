<?php
namespace models\concretes;

use Exception;
use global\Validate;
use model\abstract\InvoiceList;
use model\abstract\Person;
use model\abstract\Invoice;

use models\containers\Invoices;
use models\containers\Reviews;
use models\containers\WishLists;

class Customer extends Person {
    private InvoiceList $creditCards;
    
    
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        PostalAddress $postalAddress,
        string $emailAddress, //EmailAddress $emailAddress,
        Phone $phone,

    ) {
        parent::__construct($id, $firstname, $lastname, $postalAddress, $emailAddress, $phone);
        $this->creditCards = new InvoiceList();
    }


    public function getCreditCards (): CreditCardList {
        return $this->creditCards;
    }
    

    public function getOrderList (\DateTime $startDate, \DateTime $endDate): array {
        $matches = array();
        foreach (Invoices::getInvoices() as $order) {
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