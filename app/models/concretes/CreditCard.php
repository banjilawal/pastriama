<?php declare(strict_types=1);

namespace app\models\concretes;

use app\models\abstracts\Entity;
use app\models\abstracts\Model;
use DateTime;
use Exception;

class CreditCard extends Entity {

    public const MINIMUM_CREDIT_CARD_LENGTH = 16;
    public const MAXIMUM_CREDIT_CARD_LENGTH = 20;
    public const CREDIT_CARD_CVN_PATTERN = '/[0-9]{3}/';
    public const CREDIT_CARD_NUMBER_PATTERN = '/([0-9]{4,} ){4,}/i';
    private string $number;
    private DateTime $expiration;
    private string $cvn;

    /**
     * @param int $id
     * @param string $number
     * @param DateTime $expiration
     * @param string $cvn
     * @throws Exception
     */
    public function __construct (int $id, string $number, DateTime $expiration, string $cvn) {
        parent::__construct($id);
        $this->number = $number;
        $this->expiration = $expiration;
        $this->cvn = $cvn;
    }

    public function getNumber (): string {
        return $this->number;
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
        return parent::__toString() . ' number:' . $this->securelyPrintCardNumber()
            . ' expiration:' . $this->printExpirationDate()
            . ' cvn:' . $this->cvn;
    }

    private function securelyPrintCardNumber (): string {
        $blocks = explode(' ', $this->number);
  //      print_r($blocks);
        $lastBlock = $blocks[sizeof($blocks) - 1];
        return $this->addLeadingZeros($lastBlock);
    }

    private function printExpirationDate (): string {
        return $this->expiration->format('y') . '/' . $this->expiration->format('m');
    }

    private function addLeadingZeros ($number): string {
        $text = '' . $number;
        if ($number < 10) $text = '0' . $number;
        return $text;
    }

    public function toRow (): string {
        return '<tr id="' . $this->securelyPrintCardNumber() . '" onclick="send_card(this)">'
            . '<td>**-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>';
    }

    public function toTable (): string {
        return '<table class="card-table">'
            . '<thead>'
            . '<tr>'
            . '<th>Number</th>'
            . '<th>Expiration</th>'
            . '<th>CVN</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>**-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>'
            . '</table>'
            . '</table>';
    }
}