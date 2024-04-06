<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use Exception;

class CreditCardList extends Model {
    private array $items;

    public function __construct () {
        parent::__construct();
        $this->items = array();
    }

    public function getItems (): CreditCard|array {
        return $this->items;
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
        if (array_key_exists($card->getId(), $this->items)) {
            throw new Exception($card->getNumber() . ' is already in the list');
        }
        $this->items[$card->getId()] = $card;
    }

    /**
     * @throws Exception
     */
    public function removeCards (CreditCardList $cards): void {
        foreach ($cards as $card) {
            $this->remove($card);
        }
    }

    /**
     * @throws Exception
     */
    public function remove (CreditCard $card): void {
        if (!array_key_exists($card->getId(), $this->items)) {
            throw new Exception($card->getNumber() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->items[$card->getId()]);
    }

    public function search (String $cardNumber, string $cvn): ?CreditCard {
        foreach ($this->items as $id => $card) {
            if ($card->getNumber() === $cardNumber && $card->getCvn() === $cvn)
                return $card;
        }
        return null;
    }

    public function toString  (): string {
        $string = 'Cards:' . PHP_EOL;
        foreach ($this->items as $id => $card) {
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
        foreach ($this->items as $id => $card) {
            $elem .= $this->items[$id]->toRow();
        }
        $elem .= '<tbody></table>';
        return $elem;
    }
}