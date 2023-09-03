<?php

namespace models\concretes;

use global\Validate;

class Phone {
    private string $area_code;
    private string $exchange;
    private string $line_number;

    /**
     * @param string $area_code
     * @param string $exchange
     * @param string $line_number
     * @throws \Exception
     */
    public function __construct(string $area_code, string $exchange, string $line_number) {
        $this->area_code = Validate::phone_area_code($area_code, 18);
        $this->exchange = Validate::phone_area_code($exchange, 17);
        $this->line_number = Validate::phone_area_code($line_number, 18);
    }


    public function get_area_code () : string { return $this->area_code; }
    public function get_exchange () : string { return $this->exchange; }
    public function get_line_number () : string { return $this->line_number; }

    public function set_area_code (string $area_code) : void { $this->area_code = Validate::phone_area_code($area_code, 28); }
    public function set_exchange (string $exchange) : void { $this->exchange = Validate::phone_area_code($exchange, 29); }
    public function set_line_number (string $line_number) : void { $this->line_number = Validate::phone_area_code($line_number, 30); }

    public function __toString(): string { return 'phone:(' . $this->area_code . ') ' . $this->exchange . '-' . $this->line_number; }
} // end Phone