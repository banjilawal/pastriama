<?php
namespace models\concretes;

use Cassandra\Date;
use Exception;
use global\Validate;
use model\abstract\NamedEntity;
use models\enums\CreditCardStatus;
use models\interfaces\CustomerItem;
use function Sodium\add;

class CreditCard extends Entity implements CustomerItem {
    private \DatePeriod $expiration_year;
    private \DatePeriod $expiration_month;
    private CreditCardStatus $status;
    private int $customer_id;
    private string $number;
    private string $cvn;

    
    /**
     * @param \DatePeriod $year
     * @param \DatePeriod $month
     * @param string $number
     * @param string $cvn
     * @throws Exception
     */
    public function __construct (
        int $id,
        \DatePeriod $expiration_year,
        \DatePeriod $expiration_month,
        CreditCardStatus $status,
        int $customer_id,
        string $number,
        string $cvn
    ) {
        parent::__construct($id);
        $this->expiration_year = $expiration_year;
        $this->expiration_month = $expiration_month;
        $this->number = Validate::card_number($number, 23);
        $this->cvn = Validate::cvn_code($cvn, 24);
        $this->customer_id = $customer_id;
        $this->status = $this->status;
    } //

    public function get_expiration_year (): \DatePeriod { return $this->expiration_year; }
    public function get_expiration_month (): \DatePeriod { return $this->expiration_month; }
    public function get_number (): string { return $this->number; }
    public function get_cvn (): string { return $this->cvn; }
    public function get_status (): CreditCardStatus { return $this->status; }
    public function get_customer_id (): int { return $this->customer_id; }

    public function print_number (): string {
        $blocks = explode('-', $this->number);
        $last_block = $blocks[sizeof($blocks) - 1];
        return $this->add_leading_zeros($last_block);
    } // close print_number


    public function set_expiration_year (\DatePeriod $expiration_year): void { $this->expiration_year = $expiration_year; }
    public function set_expiration_month (\DatePeriod $expiration_month): void { $this->expiration_month = $expiration_month; }

    /**
     * @throws Exception
     */
    public function set_number (string $number): void {
        $this->number = Validate::card_number($number, 32);}

    /**
     * @throws Exception
     */
    public function set_cvn (string $cvn): void {
        $this->cvn = Validate::cvn_code($cvn, 23);
    }

    public function set_status (CreditCardStatus $status): void {
        $this->status = $status;
    }
    
    public function set_customer_id (int $customer_id): void { $this->customer_id = $customer_id;}
    
    public function equals ($object): boolean {
        if ($object instanceof CreditCard) {
            return parent::equals($object) && $this->customer_id === $object->get_customer_id()
                && $this->expiration_year === $object->get_expiration_year()
                && $this->expiration_month === $object->expiration_month
                && $this->number === $object->get_number()
                && $this->cvn == $object->get_cvn();
        }
        return false;
    }


    public function __toString() {
        return 'customer_id:' . $this->customer_id
            .  ' Credit Card:' . $this->print_number()
            . ' expiration:' . $this->print_expiration_date()
            . ' cvn' . $this->cvn;
    }

    private function print_expiration_date (): string {
//        return $this->expiration_month->format('m')
//            . '/' . $this->expiration_year->format('y');
        return add_leading_zero($this->expiration_month) . '/'
            . $this->add_leading_zero($this->expiration_year);
    } // close print_expiration_date

    private function add_leading_zero ($number): string {
        $text = '' . $number;
        if ($number < 10) $text = '0' . $number;
        return $text;
    }

    public function to_row (): string {
        $elem = '<tr id="' . $this->print_number() . '" onclick="send_card(this)">'
            . '<td>**-' . $this->print_number() . '</td>'
            . '<td>' .  $this->pprint_expiration_date() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>';
        return $elem;
    }   // close to_row


    public function to_table () {
        $elem = '<table class="card-table">'
            . '<tr>'
            . '<td>**-' . $this->print_number() . '</td>'
            . '<td>' .  $this->print_expiration_date() .'</td>'
            . '<td>' . $this->cvn . '</td>'
            . '</tr>'
            . '</table>';
        return $elem;
    } // close to_table
} // end class CreditCard