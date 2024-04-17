<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use app\models\concretes\User;
use Exception;

class CreditCardList extends Model {

    public static int $PRIMARY_CREDIT_CARD_INDEX = 0;
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
    public function getPrimaryCreditCard (): CreditCard {
        if (count($this->items) == 0) {
            throw new Exception('There are no credit cards. Cannot get nonexistent primary credit card.');
        }
        return $this->items[0];
    }

    public function setPrimaryCreditCard (CreditCard $creditCard): void {
        $locationB = $this->getIndex($creditCard);
        if ($locationB === PHP_INT_MIN) {
            $this->items[] = $creditCard;
            $locationB = count($this->items) - 1;
        }
        $this->switchCards(self::$PRIMARY_CREDIT_CARD_INDEX, $locationB);
    }


    /**
     * @throws Exception
     */
    public function addCards (CreditCardList $cards): void {
        foreach ($cards as $card) {
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

    public function searchById (int $id): ?CreditCard {
        if (!array_key_exists($id, $this->items)) {
            return $this->items[$id];
        }
        return null;
    }

    public function search (String $cardNumber, string $cvn): ?CreditCard {
        foreach ($this->items as $card) {
            if ($card->getNumber() === $cardNumber && $card->getCvn() === $cvn)
                return $card;
        }
        return null;
    }


    private function switchCards (int $locationA, int $locationB): void {
        $temp = $this->items[$locationA];
        $this->items[$locationA] = $this->items[$locationB];
        $this->items[$locationB] = $this->items[$locationA];
    }

    private function getIndex (CreditCard $target): int {
        $index = 0;
        foreach ($this->items as $creditCard) {
            if ($creditCard->equals($target)) {
                return $index;
            }
            $index++;
        }
        return PHP_INT_MIN;
    }

    public function toString  (): string {
        $string = 'Cards:' . PHP_EOL;
        foreach ($this->items as $card) {
            $string  .=  $card . PHP_EOL;
        }
        return $string;
    }

//    public function toTable (): string {
//        $elem = '<table class="table" name="credit-cards-table" id="credit-cards-table">'
//            . '<thead>'
//            . '<tr>'
//            . '<th hidden></th>'
//            . '<th>Card Number</th>'
//            . '<th>Expiration</th>'
//            . '<th>CVN</th>'
//            . '</tr>'
//            . '</thead>'
//            . '<tbody>';
//        foreach ($this->items as $id => $card) {
//            $elem .= $this->items[$id]->toRow();
//        }
//        $elem .= '<tbody></table>';
//        return $elem;
//    }

    public function toTable (): string {
        $elem = '<table id="creditCardListTable">'
            . '<thead>'
            . '<tr>'
            . '<th>Row</th>'
            . '<th>CardId</th>'
            . '<th>Vendor</th>'
            . '<th>Ending With</th>'
            . '<th>Expiration</th>'
            . '<th hidden>View Transactions</th>'
            . '<th hidden>Remove</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>';
        $counter = 1;
        foreach ($this->getItems() as $card) {
            $elem .= '<tr id="row' . $counter . '">' // onclick="rowClickHandler()">'
                . '<td>' . $counter . '</td>'
                . '<td>' . $card->getId() . '</td>'
                . '<td>'. $card->getVendor() . '</td>'
                . '<td>***- ' . $card->securelyPrintCardNumber() . '</td>'
                . '<td>' . $card->printExpirationDate() . '</td>'
                . '<td>'
                . '<button name="transactionsButton" '
                    . 'id="transactionButton' . $card->getId() . '"'
                    . 'onclick="transactionButtonHandler()">View Transactions'
                . '</button>'
                . '</td>'
                . '<td>'
                . '<button name="removeCardButton" '
                    . 'id="removeButton' . $card->getId() . '"'
                    . 'onclick="removeButtonHandler()">Remove'
                . '</button>'
                . '</td>'
                . '</tr>';
            $counter++;
        }
        $elem .= '<tbody></table>';
        return $elem;
    }

    public function creditCardSelector (): string {
        $elem = '<label for ="creditCard">Credit Card</label><select id="creditCard" name="creditCard" required>'
            . '<option value="'. $this->items[0] . '" selected>'
            . $this->items[0]->securelyPrintCardNumber . '</option>';
        for ($i = 1; $i < count($this->items); $i++) {
            $elem .= '<option value="' . $this->items[$i] . '">' . $this->items[$i]->securelyPrintCardNumber . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}