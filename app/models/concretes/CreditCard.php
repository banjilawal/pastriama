<?php declare(strict_types=1);

namespace app\models\concretes;

use app\enums\CreditCardProvider;
use app\models\abstracts\Entity;
use app\models\abstracts\Model;
use app\test\EntityGenerator;
use DateTime;
use Exception;

class CreditCard extends Entity {

    public const MINIMUM_CREDIT_CARD_LENGTH = 16;
    public const MAXIMUM_CREDIT_CARD_LENGTH = 20;
    public const CREDIT_CARD_CVN_PATTERN = '/[0-9]{3}/';
    public const CREDIT_CARD_NUMBER_PATTERN = '/([0-9]{4,} ){4,}/i';
    public const CREDIT_CARD_VENDORS = ['Mastercard', 'Visa', 'American Express', 'Discover'];

    private CreditCardProvider $cardProvider;
    private string $nameOnCard;
    private string $number;
    private DateTime $expiration;
    private string $cvn;

    /**
     * @param int $id
     * @param CreditCardProvider $cardProvider
     * @param $nameOnCard
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
        return '<tr id="' . $this->securelyPrintCardNumber() . '" onclick="send_card(this)">'
            . '<td>***-' . $this->securelyPrintCardNumber() . '</td>'
            . '<td>' .  $this->printExpirationDate() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>';
    }

    public function toTable (): string {
        return '<table class="creditCard_"' . $this->getId() .'_table">'
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

    public static function getVendorSelector (): string {
        $elem = '<label for="vendor">Credit Card Type</label>'
            . '<select id="vendor" name="vendor" required>';
        foreach (CreditCard::CREDIT_CARD_VENDORS as $vendor) {
            $elem .= '<option value"' . $vendor . '">' . $vendor . '</option>';
        }
        $elem .= '</select>';
        return $elem;
    }

    public static function getExpirationMonthSelector (): string {
        return '<label for="expirationMonth">Expiration Month </label>'
            . '<select name="expirationMonth" id="expirationMonth">'
            . '<option value="1">January</option>'
            . '<option value="2">February</option>'
            . '<option value="3">March</option>'
            . '<option value="4">April</option>'
            . '<option value="5">May</option>'
            . '<option value="6">June</option>'
            . '<option value="7">July</option>'
            . '<option value="8">August</option>'
            . '<option value="9">September</option>'
            . '<option value="10">October</option>'
            . '<option value="11">November</option>'
            . '<option value="12">December</option>'
        . '</select>';
    }

    public static function getExpirationYearSelector (int $numberOfYears=5): string {
        $currentYear= (int) date('Y');
        $elem = '<label for="expirationYear"> Expiration Year </label>'
            . '<select name="expirationYear" id="expirationYear">';
        for ($i = 0; $i < $numberOfYears; $i++) {
            $year = $currentYear + $i;
            $elem .= '<option value="' . $year . '">' . $year . '</option>';
        }
        $elem .= '</selec>';
        return $elem;
    }
}