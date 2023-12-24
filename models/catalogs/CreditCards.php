<?php
namespace models\containers;

use Exception;
use models\concretes\CreditCard;
use models\concretes\Customer;

class CreditCards {
    private array $cards = array();


    public function getCards (): array {
        return $this->cards;
    }


    /**
     * @throws Exception
     */
    public function addCard (Customer $customer, String $number, \DateTime $expirationDate, String $cvn): void {
        if (array_key_exists($number, $this->cards)) {
            throw new Exception('A card with id ' . $number . ' is already in the list');
        }
        $this->cards[$number] = new CreditCard($customer, $number, $expirationDate, $cvn);
    }
    
    public function add (CreditCard $card): void {
        $number = $card->get_number();
        if (array_key_exists($number, $this->cards)) {
            throw new Exception('A card with id ' . $number . ' is already in the list');
        }
        $this->cards[$number] = $card;
    } // close add


    public function search (Customer $customer, \DateTime $expirationDate, String $cvn): ?CreditCard {
        foreach ($this->cards as $card) {
            if ($card->getOwner() === $customer && $card->getExpirationDate() === $expirationDate && $card->getCVN() == $cvn)
                return $card;
        }
        return null;
    }



    public function searchByCustomer (Customer $customer): array {
        $matches = array();
        foreach ($this->cards as $card) {
            if ($card->getOwner() === $customer)
                $matches[] = $card;
        }
        return $matches;
    }
    
    
    public function find (CreditCard $card): CreditCard {
        return $this->card_number_search($card->get_number());
    } // close get
    
    
    public function card_number_search (String $card_number) {
        if (array_key_exists($card_number, $this->cards))
            return $this->cards[$card_number];
        else
            return null;
    } // close search
    
    
    public function __toString() {
        $string = '(Cards: ';
        foreach ($this->cards as $id => $card) {
            $string  .= $this->cards[$id] . ',';
        }
        $string = trim($string, ",");
        $string .= ' )';
        return $string;
    } // close toString
    
    
    public function toTable (): string {
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
        foreach ($this->cards as $id => $card) {
            $elem .= $this->cards[$id]->to_row();
        }
        $elem .= '<tbody></table>';
        return $elem;
    } // close to_table
    
    
    public function toSelector (): string {
        $elem = '<label for="card">Credit Card</label><br>'
            . '<select id="card" name="card">'
            . '<option value="">-- Select Your Payment Method --</option>';
        foreach ($this->cards as $id => $card) {
            $elem .= '<option value="' . $id . '">' . $this->cards[$id] . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    } // close to_selector
} // end class CreditCardBag