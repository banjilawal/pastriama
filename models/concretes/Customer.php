<?php
namespace models\concretes;

use global\Validate;
use model\abstract\Person;
use model\abstract\Purchase;
use models\containers\IntegerBag;
use models\containers\Purchases;

class Customer extends Person {
    private array $creditCards;

    private array $wishlist;
    private array $reviews;
    private IntegerBag $card_ids;
    private IntegerBag $review_ids;
    
    public function __construct (
        int $id,
        string $firstname,
        string $lastname,
        PostalAddress $postalAddress,
        EmailAddress $emailAddress,
        Phone $phone,
        CreditCard $creditCard
    ) {
        parent::__construct($id, $firstname, $lastname, $postalAddress, $emailAddress, $phone);
        $this->creditCards = array();
        $this->creditCards[$creditCard->getNumber()] = $creditCard;
    }


    /**
     * @throws \Exception
     */
    public function addCreditCard (string $cardNumber, \DateTime $expirationDate, string $cvn): void {
        $creditCard = new CreditCard($this->getFirstname(), $this->getLastname(), $cardNumber, $expirationDate, $cvn);
        if (array_key_exists($cardNumber, $this->creditCards)) {
            throw new Exception('A card with id ' . $cardNumber . ' is already in the list');
        }
        $this->creditCards[$cardNumber] = $creditCard;
    }


    public function newCard (CreditCard $card): void {
        $number = $card->get_number();
        if (array_key_exists($number, $this->cards)) {
            throw new Exception('A card with id ' . $number . ' is already in the list');
        }
        $this->creditCards[$number] = $card;
    }


    public function searchCreditCards (String $cardNumber) {
        if (array_key_exists($cardNumber, $this->creditCards))
            return $this->creditCards[$cardNumber];
        else
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


    public function creditCardTable (): string {
        $elem = '<table class="table" id="credit-cards-table" name="credit-cards-table">'
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



    public function getPurchases (\DateTime $startDate, \DateTime $endDate): array {
        $matches = array();
        foreach (Purchases::getPurchases() as $purchase) {
            if ($purchase->getCustomer() === $this && $purchase->getSubmitTime() >= $startDate && $purchase->getSubmitTime() <= $endDate)
                $matches[] = $purchase;
        }
        return $matches;
    }



    public function ordersTable (\DateTime $startDate, \DateTime $endDate): string {
        $purchases =  $this->getPurchases($startDate, $endDate);
        $tableName = 'customer-orders-table-' . $startDate->format('Y-m-d') . '-' .$endDate->format('Y-m-d');
        $elem = '<table class="customer-orders-table" id="' . $tableName . '" name="' . $tableName . '">';
            . '<thead>'
            . '<tr>'
            . '<th>Order Id</th>'
            . '<th>Submit Time</th>'
            . '<th>Estimated Delivery</th>'
            . '<th>Total Charge</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($purchases as $purchase) {
            $elem .= $purchase->toRow();
        }
        $elem .= '</tbody></table>';
        return $elem;
    }


//    public function toTable (): string {
//        $elem = '<table class="table" id="credit-cards-table" name="credit-cards-table">'
//            . '<thead>'
//            . '<tr>'
//            . '<th hidden>ID/th>'
//            . '<th>Card Number</th>'
//            . '<th>Expiration</th>'
//            . '<th>CVN</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//        foreach ($this->cards as $id => $card) {
//            $elem .= $this->cards[$id]->to_row();
//        }
//        $elem .= '<tbody></table>';
//        return $elem;
//    } // close to_table



    public function equals ($object): boolean {
        if ($object instanceof Customer) return parent::equals($object);
        return false;
    }
    
    public function __toString (): string {
        return parent::__toString();
    }
} // end class Customer