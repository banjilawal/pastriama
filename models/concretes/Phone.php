<?php

namespace models\concretes;

use Exception;
use global\Validate;

class Phone {
    private string $areaCode;
    private string $exchange;
    private string $lineNumber;

    /**
     * @param string $area_code
     * @param string $exchange
     * @param string $line_number
     * @throws Exception
     */
    public function __construct(string $area_code, string $exchange, string $line_number) {
        $this->areaCode = Validate::phone_area_code($area_code, 18);
        $this->exchange = Validate::phone_area_code($exchange, 17);
        $this->lineNumber = Validate::phone_area_code($line_number, 18);
    }
    
    
    public function getAreaCode (): string {
        return $this->areaCode;
    }
    
    
    public function getExchange (): string {
        return $this->exchange;
    }
    
    
    public function getLineNumber (): string {
        return $this->lineNumber;
    }
    
    
    /**
     * @throws Exception
     */
    public function setAreaCode (string $areaCode): void {
        $this->areaCode = Validate::phone_area_code($areaCode, 28);
    }
    
    
    /**
     * @throws Exception
     */
    public function setExchange (string $exchange): void {
        $this->exchange = Validate::phone_area_code($exchange, 29);
    }
    
    
    /**
     * @throws Exception
     */
    public function setLineNumber (string $lineNumber): void {
        $this->lineNumber = Validate::phone_area_code($lineNumber, 30);
    }
    
    
    public function equals (Object $object): bool {
        if ($object instanceof Phone) {
            return $this->areaCode === $object->getAreaCode()
                && $this->exchange === $object->getExchange()
                && $this->lineNumber === $object->getLineNumber();
        }
        return false;
    }

    
    public function __toString():string {
        return 'phone:(' . $this->areaCode . ') ' . $this->exchange . '-' . $this->lineNumber;
    }
    
    
    public function toRow (): string {
        return '<tr class="phone-row">'
            . '<td class="cell">' . $this->areaCode . '</td>'
            . '<td class="cell">' . $this->exchange . '</td>'
            . '<td class="cell">' . $this->lineNumber . '</td>'
            . '</tr>';
    }
    
    public function toTable (): string {
        return '<table class="phone-table">'
            . '<thead class="phone-table-head>'
            . '<tr>'
            . '<th>Area Code</th>'
            . '<th>Exchange</th>'
            . '<th>Number</th>'
            . '</tr>'
            . '</thead>'
            . '<tbody>'
            . '<tr>'
            . '<td>' . $this->areaCode . '</td>'
            . '<td>' . $this->exchange . '</td>'
            . '<td>' . $this->lineNumber . '</td>'
            . '</tr>'
            . '</tbody>'
            . '</table>';
    }
    

} // end Phone