<?php
namespace models\concretes;

use Exception;
use global\Validate;
use models\enums\CreditCardStatus;

class CreditCard {
    private string $ownerFirstname;
    private string $ownerLastname;
    private string $number;
    private \DateTime $expiration;
    private string $cvn;

    
    /**
     * @param \DateTime $expiration
     * @param string $number
     * @param string $cvn
     * @throws Exception
     */
    public function __construct (
        string $ownerFirstname,
        string $ownerLastname,
        string $number,
        \DateTime $expiration,
        string $cvn
    ) {
        $this->ownerFirstname = $ownerFirstname;
        $this->ownerLastname = $ownerLastname;
        $this->expiration = $expiration;
        $this->number = Validate::card_number($number, 23);
        $this->cvn = Validate::cvn_code($cvn, 24);
    }


    public function getExpiration (): \DateTime {
        return $this->expiration;
    }


    public function getExpirationMonth (): int {
        return (int) $this->expiration->format('nm');
    }

    public function getExpirationYear (): \int {
        return (int) $this->expiration->format('Y');
    }

    public function getNumber (): string {
        return $this->number;
    }

    public function getStatus (): CreditCardStatus {
        return $this->status;
    }

    public function getOwnerFirstname (): string {
        return $this->ownerFirstname;
    }

    public function getOwnerLastname (): string {
        return $this->ownerLastname;
    }


    public function getCVN (): string {
        return $this->cvn;
    }


    public function securelyPrintCardNumber (): string {
        $blocks = explode('-', $this->number);
        $last_block = $blocks[sizeof($blocks) - 1];
        return $this->addLeadingZeros($last_block);
    }
    
    
    public function equals ($object): boolean {
        if ($this == $object) return true;
        if (is_null($object )) return false;
        if ($object instanceof CreditCard) {
            return parent::equals($object) && $this->ownerFirstname === $object->getOwnerFirstname()
                && $this->ownerLastname === $object->getOwnerLastname()
                && $this->expiration === $object->getExpiration()
                && $this->number === $object->get_number()
                && $this->cvn === $object->get_cvn();
        }
        return false;
    }


    public function __toString() {
//        return 'customer_id:' . $this->customer_id
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
        $elem = '<tr id="' . $this->securelyPrintCardNumber() . '" onclick="send_card(this)">'
            . '<td>**-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->print_expiration_date() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>';
        return $elem;
    }


    public function toTable () {
        $elem = '<table class="card-table">'
            . '<tr>'
            . '<td>**-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>'
            . '</table>';
        return $elem;
    }
} // end class CreditCard