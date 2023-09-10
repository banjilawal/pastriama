<?php
namespace models\containers;

use Exception;
use models\concretes\CreditCard;

class CreditCardBag {
    private array $list = array();
    
    public function add (CreditCard $card): void {
        $number = $card->get_number();
        if (array_key_exists($number, $this->list)) {
            throw new Exception('A card with id ' . $number . ' is already in the list');
        }
        $this->list[$number] = $card;
    } // close add
    
    
    public function find (CreditCard $card): CreditCard {
        return $this->card_number_search($card->get_number());
    } // close get
    
    
    public function card_number_search (String $card_number) {
        if (array_key_exists($card_number, $this->list))
            return $this->list[$card_number];
        else
            return null;
    } // close search
    
    
    public function __toString() {
        $string = '(Cards: ';
        foreach ($this->list as $id => $card) {
            $string  .= $this->list[$id] . ',';
        }
        $string = trim($string, ",");
        $string .= ' )';
        return $string;
    } // close toString
    
    
    public function to_table (): string {
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
        foreach ($this->list as $id => $card) {
            $elem .= $this->list[$id]->to_row();
        }
        $elem .= '<tbody></table>';
        return $elem;
    } // close to_table
    
    
    public function to_selector (): string {
        $elem = '<label for="card">Credit Card</label><br>'
            . '<select id="card" name="card">'
            . '<option value="">-- Select Your Payment Method --</option>';
        foreach ($this->list as $id => $card) {
            $elem .= '<option value="' . $id . '">' . $this->list[$id] . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    } // close to_selector
    
    
    public function get_list (): array { return $this->list; }
} // end class CreditCardBag