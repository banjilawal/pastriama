<?php
namespace models\concretes;

use Exception;
use global\Validate;
use model\abstract\Entity;
use models\enums\CreditCardStatus;

class CreditCard extends Entity {
    private string $number;
    private \DateTime $expiration;
    private string $cvn;
    
    /**
     * @param string $ownerFirstname
     * @param string $ownerLastname
     * @param string $number
     * @param \DateTime $expiration
     * @param string $cvn
     * @throws Exception
     */
    public function __construct (
        int $id,
        string $number,
        \DateTime $expiration,
        string $cvn
    ) {
        parent::__construct($id);
        $this->expiration = $expiration;
        $this->number = Validate::card_number($number, 23);
        $this->cvn = Validate::cvn_code($cvn, 24);
    }


    public function getExpiration (): \DateTime {
        return $this->expiration;
    }


    public function getExpirationMonth (): int {
        return (int) $this->expiration->format('m');
    }

    public function getExpirationYear (): \int {
        return (int) $this->expiration->format('Y');
    }

    public function getNumber (): string {
        return $this->number;
    }
    


    public function getCVN (): string {
        return $this->cvn;
    }


    public function securelyPrintCardNumber (): string {
        $blocks = explode('-', $this->number);
        $last_block = $blocks[sizeof($blocks) - 1];
        return $this->addLeadingZeros($last_block);
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
        return __CLASS__ . ':' . $this->securelyPrintCardNumber()
//            .  ' Credit Card:' . $this->print_number()
            . ' expiration:' . $this->printExpirationDate ()
            . ' cvn' . $this->cvn;
    }


    private function printExpirationDate (): string {
        return $this->expiration->format('Y') . '-' . $this->expiration->format('m');
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
            . '<tr>'
            . '<td>**-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>'
            . '</table>';
    }
} // end class CreditCard