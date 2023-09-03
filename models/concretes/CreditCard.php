<?php
namespace models\concretes;

use Cassandra\Date;
use global\Validate;
use model\abstract\NamedEntity;

class CreditCard  {
    private \DatePeriod $year;
    private \DatePeriod $month;
    private string $number;
    private string $cvn;

    /**
     * @param \DatePeriod $year
     * @param \DatePeriod $month
     * @param string $number
     * @param string $cvn
     * @throws \Exception
     */
    public function __construct (\DatePeriod $year, \DatePeriod $month, string $number, string $cvn) {
        $this->year = $year;
        $this->month = $month;
        $this->number = Validate::card_number($number, 23);
        $this->cvn = Validate::cvn_code($cvn, 24);
    }

    public function get__year (): \DatePeriod { return $this->year; }
    public function get_month (): \DatePeriod { return $this->month; }
    public function get_number (): string { return $this->number; }
    public function get_cvn ( ): string { return $this->cvn; }


    public function set__year (\DatePeriod $year): void { $this->year = $year; }
    public function set__month (\DatePeriod $month): void { $this->month = $month; }

    /**
     * @throws \Exception
     */
    public function set_number (\string $number): void {
        $this->number = Validate::card_number($number, 32);}

    /**
     * @throws \Exception
     */
    public function cvn_code (string $cvn): void { $this->cvn = Validate::cvn_code($cvn, 23); }

    private function number_string($number): string {
        $text = '' . $number;
        if ($number < 10) $text = '0' . $number;
        return $text;
    }

    public function __toString() {
        return 'Credit Card:' . $this->number
            . ' ' . $this->number_string($this->month)
            . '/' . $this->number_string($this->year)
            . ' ' . $this->cvn;
    }
} // end class CreditCard