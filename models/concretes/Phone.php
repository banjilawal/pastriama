<?php

namespace models\concretes;

use global\Validate;

class Phone {
    private int $customer_id;
    private string $area_code;
    private string $exchange;
    private string $line_number;

    /**
     * @param string $area_code
     * @param string $exchange
     * @param string $line_number
     * @throws \Exception
     */
    public function __construct(Customer $customer, string $area_code, string $exchange, string $line_number) {
        $this->customer_id = $customer->getId();
        $this->area_code = Validate::phone_area_code($area_code, 18);
        $this->exchange = Validate::phone_area_code($exchange, 17);
        $this->line_number = Validate::phone_area_code($line_number, 18);
    }
    
    public function get_customer_id (): int { return $this->customer_id; }
    public function get_area_code () : string { return $this->area_code; }
    public function get_exchange () : string { return $this->exchange; }
    public function get_line_number () : string { return $this->line_number; }
    public function set_customer_id (Customer $customer) :void { $this->customer_id = $customer->getId(); }
    
    /**
     * @throws \Exception
     */
    public function set_area_code (string $area_code) : void { $this->area_code = Validate::phone_area_code($area_code, 28); }
    
    
    /**
     * @throws \Exception
     */
    public function set_exchange (string $exchange) : void { $this->exchange = Validate::phone_area_code($exchange, 29); }
    
    
    /**
     * @throws \Exception
     */
    public function set_line_number (string $line_number) : void { $this->line_number = Validate::phone_area_code($line_number, 30); }
    
    
    public function equals (Object $object): boolean {
        if ($object instanceof Phone) {
            return $this->customer_id == $object->get_customer_id()
                && $this->area_code === $object->get_area_code()
                && $this->exchange === $object->get_exchange()
                && $this->line_number === $object->get_line_number();
        }
        return false;
    }

    
    public function __toString(): string { return 'phone:(' . $this->area_code . ') ' . $this->exchange . '-' . $this->line_number; }
    
    public function to_row () {
        $elem = '<tr class="phone-row">'
            . '<td class="cell">' . $this->area_code . '</td>'
            . '<td class="cell">' . $this->exchange . '</td>'
            . '<td class="cell">' . $this->line_number . '</td>'
            . '</tr>';
        return $elem;
    } // close to_row;
    
    public function to_table () {
        $elem = '<table class="phone-table">'
            . '<thead class="phone-table-head>'
            . '<tr class="phone-table-header-row">'
            . '<th>Area Code</th>'
            . '<th>Exchange</th>'
            . '<th>Number</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->area_code . '</td>'
            . '<td>' . $this->exchange . '</td>'
            . '<td>' . $this->line_number . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';
        return $elem;
    } // close function to_table
    
    /**
     * @throws \Exception
     */
    public static function build (String $string): Phone {
        $areaCode = substr($string, (strpos($string,'(') + 1 ),  (strpos($string,')') - 1 ) );
        $exchange = substr($string, (strpos($string,' ') + 1 ),  (strpos($string,')') - 1 ) );
        $number = substr($string, (strpos($string,'-') + 1 ) );
        return new Phone($areaCode, $exchange, $number);
    } // close build
} // end Phone