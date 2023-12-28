<?php
namespace Shop\Model\collections;

use Exception;
use models\concretes\CreditCard;

class CreditCardList {
    private array $cards;
    
    
    public function __construct () {
        $this->cards = array();
    }


    public function getCards (): CreditCard|array {
        return $this->cards;
    }
    
    /**
     * @throws Exception
     */
    public function addCards (ReviewList $cards): void {
        foreach ($cards as $id => $card) {
            $this->add($card);
        }
    }


    /**
     * @throws Exception
     */
    public function add (CreditCard $card): void {
        if (array_key_exists($card->getId(), $this->cards)) {
            throw new Exception($card->getNumber() . ' is already in the list');
        }
        $this->cards[$card->getId()] = $card;
    }


    /**
     * @throws Exception
     */
    public function removeCards (ReviewList $cards): void {
        foreach ($cards as $id => $card) {
            $this->remove($card);
        }
    }


    /**
     * @throws Exception
     */
    public function remove (CreditCard $card): void {
        if (!array_key_exists($card->getId(), $this->cards)) {
            throw new Exception($card->getNumber() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->cards[$card->getId()]);
    }


    public function search (String $cardNumber): ?CreditCard {
        foreach ($this->cards as $id => $card) {
            if ($card->getNumber() === $cardNumber)
                return $card;
        }
        return null;
    } // close search
    

    public function toString  (): string {
        $string = nl2br('Cards:');
        foreach ($this->cards as $id => $card) {
            $string  .= nl2br($card);
        }
        return $string;
    }


    public function toTable (): string {
        $elem = '<table class="table" name="credit-cards-table" id="credit-cards-table">'
            . '<thead>'
            . '<tr>'
            . '<th hidden>ID</th>'
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
    }
}