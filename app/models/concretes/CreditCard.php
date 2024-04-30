<?php declare(strict_types=1);

namespace app\models\concretes;

use app\enums\CreditCardProvider;
use app\models\abstracts\Entity;
use app\models\abstracts\Model;
use app\test\NewEntityGenerator;
use DateTime;
use Exception;

class CreditCard extends Entity {

    private CreditCardProvider $cardProvider;
    private string $nameOnCard;
    private string $number;
    private DateTime $expiration;
    private string $cvn;

    /**
     * @param int $id
     * @param CreditCardProvider $cardProvider
     * @param string $nameOnCard
     * @param string $number
     * @param DateTime $expiration
     * @param string $cvn
     * @throws Exception
     */
    public function __construct (
        int $id,
        CreditCardProvider $cardProvider,
        string $nameOnCard,
        string $number,
        DateTime $expiration,
        string $cvn
    ) {
        parent::__construct($id);
        $this->nameOnCard = $nameOnCard;
        $this->cardProvider = $cardProvider;
        $this->number = $number;
        $this->expiration = $expiration;
        $this->cvn = $cvn;
    }

    public function getCardProvider (): CreditCardProvider {
        return $this->cardProvider;
    }

    public function getNameOnCard (): string {
        return $this->nameOnCard;
    }

    public function getNumber (): string {
        return $this->number;
    }

    public function getSecureNumber (): string {
        $blocks = explode(' ', $this->number);
        $lastBlock = $blocks[sizeof($blocks) - 1];
        return $this->addLeadingZeros($lastBlock);
    }

    public function getCVN (): string {
        return $this->cvn;
    }

    public function getExpiration (): DateTime {
        return $this->expiration;
    }

    public function equals ($object): bool {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof CreditCard) {
            return parent::equals($object)
                && $this->expiration === $object->getExpiration()
                && $this->number === $object->getNumber()
                && $this->cvn === $object->getCvn();
        }
        return false;
    }

    public function __toString(): string {
        return parent::__toString() . ' ' . $this->cardProvider->value
            . ' number:' . $this->securelyPrintCardNumber()
            . ' expiration:' . $this->printExpirationDate()
            . ' cvn:' . $this->cvn;
    }

    public function securelyPrintCardNumber (): string {
        $blocks = explode(' ', $this->number);
  //      print_r($blocks);
        $lastBlock = $blocks[sizeof($blocks) - 1];
        return $this->addLeadingZeros($lastBlock);
    }

    public function printExpirationDate (): string {
        return $this->expiration->format('m') . '/' . $this->expiration->format('y');
    }

    private function addLeadingZeros ($number): string {
        $text = '' . $number;
        if ($number < 10) $text = '0' . $number;
        return $text;
    }

    public function printCardNumber (): string {
        return $this->securelyPrintCardNumber();
    }

    public function toRow (): string {
        return '<tr id="' . $this->securelyPrintCardNumber() . '" onclick="handleRowClick(this)">'
            . '<td>***-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>';
    }

    public function toTable (): string {
        return '<table id="creditCard_"' . $this->getId() .'_table">'
            . '<thead>'
            . '<tr>'
            . '<th>ID</th>'
            . '<th>Vendor</th>'
            . '<th>Number</th>'
            . '<th>Expiration</th>'
            . '<th>CVN</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->getId() . '</td>'
            . '<td>' . $this->cardProvider->value . '</td>'
            . '<td>**-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>'
            . '</table>'
            . '</table>';
    }
}