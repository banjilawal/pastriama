<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use Exception;

class CreditCardList extends Model {
    private array $cards;

    public function __construct () {
        parent::__construct();
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

    public function search (String $cardNumber, string $cvn): ?CreditCard {
        foreach ($this->cards as $id => $card) {
            if ($card->getNumber() === $cardNumber && $card->getCvn() === $cvn)
                return $card;
        }
        return null;
    }

    public function toString  (): string {
        $string = 'Cards:' . PHP_EOL;
        foreach ($this->cards as $id => $card) {
            $string  .=  $card . PHP_EOL;
        }
        return $string;
    }

    public function toTable (): string {
        $elem = '<table class="table" name="credit-cards-table" id="credit-cards-table">'
            . '<thead>'
            . '<tr>'
            . '<th hidden></th>'
            . '<th>Card Number</th>'
            . '<th>Expiration</th>'
            . '<th>CVN</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        foreach ($this->cards as $id => $card) {
            $elem .= $this->cards[$id]->toRow();
        }
        $elem .= '<tbody></table>';
        return $elem;
    }
}