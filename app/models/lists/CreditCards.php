<?php declare(strict_types=1);

namespace app\models\lists;

use app\models\abstracts\Model;
use app\models\concretes\CreditCard;
use app\models\concretes\User;
use Exception;

class CreditCards extends Model {

    public static int $PRIMARY_CREDIT_CARD_INDEX = 0;
    private array $list;


    public function __construct () {
        parent::__construct();
        $this->list = array();
    }

    public function getList (): CreditCard|array {
        return $this->list;
    }

    /**
     * @throws Exception
     */
    public function getPrimaryCreditCard (): CreditCard {
        if (count($this->list) == 0) {
            throw new Exception('There are no credit cards. Cannot get nonexistent primary credit card.');
        }
        return $this->list[0];
    }

    public function setPrimaryCreditCard (CreditCard $creditCard): void {
        $locationB = $this->getIndex($creditCard);
        if ($locationB === PHP_INT_MIN) {
            $this->list[] = $creditCard;
            $locationB = count($this->list) - 1;
        }
        $this->switchCards(self::$PRIMARY_CREDIT_CARD_INDEX, $locationB);
    }


    /**
     * @throws Exception
     */
    public function addCards (CreditCards $cards): void {
        foreach ($cards as $card) {
            $this->addCard($card);
        }
    }

    /**
     * @throws Exception
     */
    public function addCard (CreditCard $card): void {
        if (array_key_exists($card->getId(), $this->list)) {
            throw new Exception($card->getNumber() . ' is already in the list');
        }
        $this->list[$card->getId()] = $card;
    }

    /**
     * @throws Exception
     */
    public function removeCards (CreditCards $cards): void {
        foreach ($cards as $card) {
            $this->removeCard($card);
        }
    }

    /**
     * @throws Exception
     */
    public function removeCard (CreditCard $card): void {
        if (!array_key_exists($card->getId(), $this->list)) {
            throw new Exception($card->getNumber() . ' is not in the list. Cannot remove nonexistent card');
        }
        unset($this->list[$card->getId()]);
    }

    public function searchById (int $id): ?CreditCard {
        if (!array_key_exists($id, $this->list)) {
            return $this->list[$id];
        }
        return null;
    }

    public function search (String $cardNumber, string $cvn): ?CreditCard {
        foreach ($this->list as $card) {
            if ($card->getNumber() === $cardNumber && $card->getCvn() === $cvn)
                return $card;
        }
        return null;
    }

    public function contains (CreditCard $card): bool {
        return array_key_exists($card->getId(), $this->list);
    }


    private function switchCards (int $locationA, int $locationB): void {
        $temp = $this->list[$locationA];
        $this->list[$locationA] = $this->list[$locationB];
        $this->list[$locationB] = $this->list[$locationA];
    }

    private function getIndex (CreditCard $target): int {
        $index = 0;
        foreach ($this->list as $creditCard) {
            if ($creditCard->equals($target)) {
                return $index;
            }
            $index++;
        }
        return PHP_INT_MIN;
    }

    public function toString  (): string {
        $string = 'Cards:' . PHP_EOL;
        foreach ($this->list as $card) {
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
        foreach ($this->getList() as $card) {
            $elem .= '<tr id="row' . $counter . '">' // onclick="rowClickHandler()">'
                . '<td>' . $counter . '</td>'
                . '<td>' . $card->getId() . '</td>'
                . '<td>'. $card->getCardProvider()->value . '</td>'
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

    public function selector (): string {
        $elem = '<label for ="creditCard">Credit Card</label><select id="creditCard" name="creditCard" required>'
            . '<option value="'. $this->list[0] . '" selected>'
            . $this->list[0]->securelyPrintCardNumber . '</option>';
        for ($i = 1; $i < count($this->list); $i++) {
            $elem .= '<option value="' . $this->list[$i] . '">' . $this->list[$i]->securelyPrintCardNumber . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }
}